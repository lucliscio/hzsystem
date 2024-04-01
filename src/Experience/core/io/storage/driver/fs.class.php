<?php

    /*
     * fs.class.php
     *
     *                                         __  __                _
     *                                      ___\ \/ /_ __   ___ _ __(_) ___ _ __   ___ ___
     *                                     / _ \\  /| '_ \ / _ \ '__| |/ _ \ '_ \ / __/ _ \
     *                                    |  __//  \| |_) |  __/ |  | |  __/ | | | (_|  __/
     *                                     \___/_/\_\ .__/ \___|_|  |_|\___|_| |_|\___\___|
     *                                              |_| HZKnight free PHP Scripts
     *
     *                                           lucliscio <lucliscio@h0model.org>, ITALY
     *
     * CORE Ver.1.0.0
     *
     * -------------------------------------------------------------------------------------------
     * License
     * -------------------------------------------------------------------------------------------
     * Copyright (C)2023 HZKnight
     *
     * This program is free software: you can redistribute it and/or modify
     * it under the terms of the GNU Affero General Public License as published by
     * the Free Software Foundation, either version 3 of the License, or
     * (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     * GNU Affero General Public License for more details.
     *
     * You should have received a copy of the GNU Affero General Public License
     * along with this program.  If not, see <http://www.gnu.org/licenses/agpl-3.0.html>.
     * -------------------------------------------------------------------------------------------
     */

    namespace Experience\Core\Io\Storage\Driver;

    use Experience\Core\Io\Storage\Driver\Interface\StorageDriveInterface;
    use Experience\Core\Io\Storage\Exceptions\StorageException;

    /**
     * Driver per lo standard stage (file system)
     *
     * @author  lucliscio <lucliscio@h0model.org>
     * @version v 1.0.0
     * @copyright Copyright 2024 HZKnight
     * @license http://www.gnu.org/licenses/agpl-3.0.html GNU/AGPL3
     *
     * @package eXperience
     * @filesource
     */

    class Fs implements StorageDriveInterface{    
        private $WEB_ROOT;

        public function __construct($path="/"){
            $this->WEB_ROOT = getcwd().$path;
        }


        /**
         * Make a directory
         *
         * @param string $name
         * @param string $mode
         * @return void
         */
        public function mkdir($name, $mode=0777){
            settype($name,"string");

            clearstatcache();

            if(is_dir($name)){
               return; 
            } elseif(mkdir($name,$mode)){
                clearstatcache();

                if(is_dir($name)){
                    return; 
                }
            }

            throw new StorageException("System Error: mkdir(".$name.",".$mode.")", "S01");
        }


        /**
         * Delete file and directory
         *
         * @param string $name
         * @return void
         */
        public function rm($name){
            settype($name,"string");

            clearstatcache();

            $source = $this->WEB_ROOT.$name;

            if(!file_exists($source)){
                return;
            } else if(!is_writable($source)){
                throw new StorageException("System Error: rm(".$source.") - File not writable", "S01");
            } else {
                if(is_dir($source)){
                    $it = new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS);
                    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
                    foreach($files as $file) {
                        $this->rm($file->getPathname());
                    }
                    rmdir($source);
                } else {
                    unlink($source);
                }

                clearstatcache();
    
                if(!file_exists($source)){
                    return;
                }
                
                throw new StorageException("System Error: rm(".$source.")", "S01");
            }            
        }


        /**
         * File copy
         *
         * @param string $source
         * @param string $target
         * @return void
         */
        public function fcopy($source,$target){
            settype($source,"string");
            settype($target,"string");
          
            clearstatcache();
          
            if(!file_exists($this->WEB_ROOT.$source)){
                return;
            } elseif(copy($this->WEB_ROOT.$source, $this->WEB_ROOT.$target)){
                clearstatcache();
          
                if(file_exists($this->WEB_ROOT.$target)){
                    if(file_get_contents($this->WEB_ROOT.$__target) === file_get_contents($this->WEB_ROOT.$__source)){
                        return;
                    }
                }
            }
          
            $this->rm($target);
            throw new StorageException("System Error: fcopy(".$this->WEB_ROOT.$source.",".$this->WEB_ROOT.$target.")", "S01");
        }


        /**
         * Directory listing
         *
         * @param string $dir
         * @param string $pattern
         * @return array $ls
         */
        public function ls($dir="./",$pattern="*.*"): array{
            settype($dir,"string");
            settype($pattern,"string");

            $source = $this->WEB_ROOT.$dir;

            clearstatcache();

            $ls=array();
            $regexp=preg_replace("/\\x5C\\x3F/",".",preg_replace("/\\x5C\\x2A/",".*",preg_quote($pattern,"/")));

            if(is_dir($source)){
                $it = new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS);
                $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
                foreach($files as $file) {
                    $fileName = $file->getFilename();
                    if(preg_match("/^".$regexp."$/", $fileName)){
                        array_push($ls, $fileName);
                    }
                }

                sort($ls,SORT_STRING);
                return $ls;
            }
           
            throw new StorageException("System Error: ls(".$source.",".$pattern.")", "S01");
        }
    }
<?php

    namespace Experience\Core\Logger\Appenders;
        
    use Experience\Core\Exceptions\ENotApplicableMethodException;
        
    use Experience\Core\Logger\ELogLevel;
    use Experience\Core\Logger\ELogRow;
    
    require($_SESSION["experience_path"].str_replace('/', DIRECTORY_SEPARATOR,'Experience/vendor/FirePHPCore/FirePHP.class.php'));
	
    /*
     * Copyright (C) 2020 HZKnight
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
     */

    /**
     *  FireBUG appender per HZLogger 
     *
     *  @author  Luca Liscio <hzkight@h0model.org>
     *  @version 0.0.4 2020/12/03 22:41:20
     *  @copyright 2020 HZKnight
     *  @license http://www.gnu.org/licenses/agpl-3.0.html GNU/AGPL3
     *
     *  @package Experience
     *  @subpackage Core\Logger\Appenders
     *  @filesource
     */
        
    class Appender_firephp extends Appender {

        /**
         * Save one row in the log file
         * 
         * @param ELogRow $log_row
         */
        public function add(ELogRow $log_row){
            
            $firephp = \FirePHP::getInstance(true);

            //Log levels mapping
            switch($log_row->type){
                case ELogLevel::ALERT :
                    $firephp->fb("[".$log_row->date."] ".$log_row->message,\FirePHP::ERROR);
                    break;
                case ELogLevel::CRITICAL :
                    $firephp->fb("[".$log_row->date."] ".$log_row->message,\FirePHP::ERROR);
                    break;
                case ELogLevel::ERROR :
                    $firephp->fb("[".$log_row->date."] ".$log_row->message,\FirePHP::ERROR);
                    break;
                case ELogLevel::WARNING :
                    $firephp->fb("[".$log_row->date."] ".$log_row->message,\FirePHP::WARN);
                    break;
                case ELogLevel::NOTICE :
                    $firephp->fb("[".$log_row->date."] ".$log_row->message,\FirePHP::WARN);
                    break;
                case ELogLevel::INFO :
                    $firephp->fb("[".$log_row->date."] ".$log_row->message,\FirePHP::INFO);
                    break;
                case ELogLevel::DEBUG :
                    $firephp->fb("[".$log_row->date."] ".$log_row->message,\FirePHP::LOG);
                    break;
            }
                    
	    }
	
        /**
         * Method not applicable
         * 
         * @throws ENotApplicableMethodException
         */
	    public function get_log($start=0,$stop){
                    
            throw new ENotApplicableMethodException(dgettext("Elang","Method not applicable"));
                    
	    }
		
    }
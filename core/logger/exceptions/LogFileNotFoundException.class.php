<?php

    namespace HZSystem\Core\Logger\Exceptions;
	
    use HZSystem\Exceptions\HZException;
	
    /*
     * Copyright (C) 2015 Luca Liscio
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
     *  questa eccezione si verifica quando si prova a richiamare un log file che non esiste
     *
     *  @author  Luca Liscio <hzkight@h0model.org>
     *  @version 0.0.1 2015/12/19 16:41:20
     *  @copyright 2015 Luca Liscio
     *  @license http://www.gnu.org/licenses/agpl-3.0.html GNU/AGPL3
     *
     *  @package hzSystem
     *  @subpackage Core\Logger\Exception
     *  @filesource
     */
	 
    class LogFileNotFoundException extends HZException{
        protected $code = "L02"; 
    }
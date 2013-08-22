<?php 

/**
 * @author Olanipekun Israel Olufemi
 * @name Shift Numbers
 * @version 0.1
 * @license GPL V3
 * @link https://github.com/iolufemi/Shift-Numbers
 * @copyright 2013 Olanipekun Israel Olufemi
 * @tutorial Just set the class variables and input the phonenumbers in the datafile you have set in
 * this manner(without qoutes) "08056552980/Morning - 08076876565/Night - 08078767654/Default". Use morning for the 
 * phone numbers to display in the morning shift, night for night shift, and 
 * default for the default phone number(this will show in the free times.)
 * 
 * This is a script that will change the customer support phone numbers on the whogohost 
 * website according to the custommer care representatives on shift. NO NEED FOR DATABASE! :)
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * */
 class shiftNumbers{
    private $currentTime;
    private $phoneNumbers;
    private $dataFilePath = 'shiftnumbers.data';
    private $timezone = 'Africa/Lagos';
    private $morningStart = '09:00';
    private $morningEnd = '17:00';
    private $nightStart = '21:00';
    private $nightEnd = '07:00';
    
    /**
     * shiftNumbers::__construct()
     * initiallize the shiftNumbers class
     * @return void
     */
    public function __construct(){
        date_default_timezone_set($this->timezone);
    }
    
    /**
     * shiftNumbers::getPhoneNumbersWithShiftTimes()
     * returns an array of the phone numbers mapped with their shift time.
     * @return array
     */
    private function getPhoneNumbersWithShiftTimes(){
        $fileData = file_get_contents($this->getDataFilePath());
        $splitData = explode('-',$fileData);
        foreach($splitData as $shifts){
            $treatedShifts[] = trim(strtolower($shifts));
        }
        foreach($treatedShifts as $phoneNumbers){
            $splitPhoneNumbers = explode('/',$phoneNumbers);
            if(in_array('morning',$splitPhoneNumbers)){
                $thenumber['number'] = $splitPhoneNumbers[0];
                $thenumber['start'] = $this->getMorningShiftStartTime();
                $thenumber['end'] = $this->getMorningShiftEndTime();
                $numbers[] = $thenumber; 
            }
            if(in_array('night',$splitPhoneNumbers)){
                $thenumber['number'] = $splitPhoneNumbers[0];
                $thenumber['start'] = $this->getNightShiftStartTime();
                $thenumber['end'] = $this->getNightShiftEndTime();
                $numbers[] = $thenumber; 
            }
        }
        return $numbers;
        
    }
    
    /**
     * shiftNumbers::getDefault()
     * returns the default phone number
     * @return array
     */
    private function getDefault(){
        $fileData = file_get_contents($this->getDataFilePath());
        $splitData = explode('-',$fileData);
        foreach($splitData as $shifts){
        $treatedShifts[] = trim(strtolower($shifts));
        }
        foreach($treatedShifts as $phoneNumbers){
            $splitPhoneNumbers = explode('/',$phoneNumbers);
            if(in_array('default',$splitPhoneNumbers)){
                 $numbers[] = $splitPhoneNumbers[0];
            }
        }
        return $numbers;
    }
    
    /**
     * shiftNumbers::getCurrentTime()
     * returns the current time
     * @return unix time format
     */
    private function getCurrentTime(){
        $this->currentTime = time();
        return $this->currentTime;
    }
    
    /**
     * shiftNumbers::getDataFilePath()
     * Returns the data file path.
     * @return string
     */
    private function getDataFilePath(){
        return $this->dataFilePath;
    }
    
    /**
     * shiftNumbers::getTimeZone()
     * Returns the set timezone for this script
     * @return string
     */
    private function getTimeZone(){
        return $this->timezone;
    }
    
    /**
     * shiftNumbers::getMorningShiftStartTime()
     * returns the start time for the morning shift. 
     * @return unix time format
     */
    private function getMorningShiftStartTime(){
        $time = strtotime($this->morningStart);
        return $time;
    }
    
    /**
     * shiftNumbers::getMorningShiftEndTime()
     * returns the end time for the morning shift.
     * @return unix time format
     */
    private function getMorningShiftEndTime(){
        $time = strtotime($this->morningEnd);
        return $time;
    }
    
    /**
     * shiftNumbers::getNightShiftStartTime()
     * returns the start time for the night shift
     * @return unix time format
     */
    private function getNightShiftStartTime(){
        $time = strtotime($this->nightStart);
        return $time;
    }
    
    /**
     * shiftNumbers::getNightShiftEndTime()
     * returns the end time for the night shift
     * @return unix time format
     */
    private function getNightShiftEndTime(){
        $time = strtotime($this->nightEnd);
        return $time;
    }
    
    /**
     * shiftNumbers::currentShiftPhoneNumbers()
     * returns the current shift phone number
     * @return array
     */
    public function currentShiftPhoneNumbers(){
        $time = $this->getCurrentTime();
        $shift = $this->getPhoneNumbersWithShiftTimes();
        $count = count($shift);
        $last = $count - 1;
        if($count > 1){
            $comma = ', ';
        }else{
            $comma = '';
        }
        for($c = 0; $c < $count; $c++){
            if($c == $last){
                $comma = '';
            }
            if($shift[$c]['start'] <= $time && $time <= $shift[$c]['end']){
                $thenumber[$c] = $shift[$c]['number'].$comma;
            }
            
        }
        return $thenumber;
    }
    
        /**
     * shiftNumbers::currentShiftPhoneNumbersAsString()
     * returns the current shift phone number
     * @return string
     */
    public function currentShiftPhoneNumbersAsString(){
        $theString = '';
        $time = $this->getCurrentTime();
        $shift = $this->getPhoneNumbersWithShiftTimes();
        $count = count($shift);
        $last = $count - 1;
        if($count > 1){
            $comma = ', ';
        }else{
            $comma = '';
        }
        for($c = 0; $c < $count; $c++){
            if($c == $last){
                $comma = '';
            }
            if($shift[$c]['start'] <= $time && $time <= $shift[$c]['end']){
                $theString .= $shift[$c]['number'].$comma;
            }
            
        }
        return $theString;
    }
    
    /**
     * shiftNumbers::run()
     * echos the current shift phone number
     * @return void
     */
    public function run(){
        $default = $this->getDefault();
        $check = $this->currentShiftPhoneNumbers();
        $count = count($default);
        $last  = $count - 1;
        $thestring = "";
        if(!$check){
        if($count > 1){
            $comma = ', ';
        }else{
            $comma = '';
        }
        $c = 0;
            foreach($default as $defaults){
                if($c == $last){
                    $comma = '';
                }
                $thestring .= $defaults.$comma;
                $c++;
        }
        }else{
            foreach($check as $phoneNumber){
                $thestring .= $phoneNumber;
            }
        }
        echo $thestring;
    }
 }
 
?>
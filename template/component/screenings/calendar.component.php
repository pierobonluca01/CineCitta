<?php
namespace screenings;
require_once("./template/component/screenings/screenings.php");

class Calendar extends Screenings {
    
    public function __construct() {
        parent::__construct("calendar");
        $this->build();
    }

    public function build() {
        if(!isset($_GET['date'])) {
            $_GET['date'] = strftime("%Y-%m-%d");
        }
        if(isset($_GET['picker'])) {
            $this->replaceTag("PICKER", new Screenings("datePicker"));
        } else {
            $this->replaceTag("PICKER", "");
        }
        if(isset($_GET['date'])) {
            $data = strtotime($_GET['date']);
            $this->replaceValue("Data", ucfirst(strftime("%A ", $data)) . strftime("%d %B %Y", $data));
            $this->replaceValue("DataValue", strftime("%Y-%m-%d", $data));
            $this->replaceValue("DataNextFormatted", strftime("%d/%m/%Y", $data+86400));
            $this->replaceValue("DataNext", strftime("%Y-%m-%d", $data+86400));
            $this->replaceValue("DataPreviousFormatted", strftime("%d/%m/%Y", $data-86400));
            $this->replaceValue("DataPrevious", strftime("%Y-%m-%d", $data-86400));
        }
    }

}
?>
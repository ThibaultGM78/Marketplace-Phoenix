<?php
    function field($name,$classField,$nameField,$classLabel,$classInput,$typeInput,$classSpan,$idSpan,$classError,$msgError,$value,$errors){
     
        if(isset($errors[$name])){
            $classInput = $classError;
            $classSpan = "";
        }
        echo '
            <div class="'.$classField.'">
                <label for="'.$name.'" class="'.$classLabel.'">'.$nameField.' :</label>
                <input type="'.$typeInput.'" id="'.$name.'" name="'.$name.'" class="'.$classInput.'" value="'. $value.'">
                <span id="'.$idSpan.'" class="'.$classSpan.'"> '.$msgError.'</span>
            </div>
        ';
    }
?>
<!--S*-->
<?php
/**
* Classe pour créer et gérer un formulaire
* @author Amaury Lavieille
*/
namespace MvcApp\Core;

/**
* Classe qui représente un formulaire
*/
class Form 
{   
    /**
    * @var String $action 
    */
    private $action;
    
    /**
    * @var Array $htmlOptions
    */
    private $htmlOptions;
    
    /**
    * @var String $method
    */
    private $method;

    /**
    * @var Object $model
    */
    private $model;

    /**
    * Constructeur
    * @param Object $model Model utilisé pour le formulaire
    * @param String $action action lors de la validation
    * @param Array $htmlOptions exemple array("id"=>"monid")
    * @param String $method $_GET ou $_POST par défaut POST
    */
    public function __construct($model,$action,$htmlOptions=array(),$method="post")
    {
        $this->action = $action;
        $this->model = $model;
        $this->htmlOptions = $htmlOptions;
        $this->method = $method;
    }

    /**
    * Retourne la balise ouvrante d'un formulaire
    */
    public function beginForm()
    {
        $res = "";
        $res .= "<form action='".$this->action."' method='".$this->method."' ";
        foreach ($this->htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        $res .= "/>\n";
        echo $res;
    }

    /**
    * Affiche la balise fermante du formulaire
    **/
    public function endForm()
    {
        echo "</form>\n";
    }

    /**
    * Ajoute un label
    * @param String $name champ for du label
    * @param String $content contenue du label
    * @param Array $htmlOptions
    * @return String $res
    */
    public function label($name,$content,$htmlOptions=array())
    {
        $res = "<label for='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        $res .= ">".$content."</label>\n";
        return $res;
    }


    /**
    * Ajoute un input texte
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputText($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }

        $res .= "<input type='text' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        
        $res .="value='".$this->model->$name."'";
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute un input email
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputEmail($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }
        $res .= "<input type='email' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }

        $res .="value='".$this->model->$name."'";
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute un input hidden
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputHidden($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }

        $res .= "<input type='hidden' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        
        $res .="value='".$this->model->$name."'";
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute un input password
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputPassword($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }
        $res .= "<input type='password' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        
        $res .="value='".$this->model->$name."'";
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute un input file
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputFile($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }
        $res .= "<input type='file' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
       
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute un input date
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputDate($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }

        $res .= "<input type='date' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
     
        $res .="value='".$this->model->$name."'";
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute un input number
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputNumber($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }
        $res .= "<input type='number' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        
        $res .="value='".$this->model->$name."'";
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }   

    /**
    * Ajoute un input url
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputUrl($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }
        $res .= "<input type='url' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
      
        $res .="value='".$this->model->$name."'";
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute un input tel
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputTel($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }

        $res .= "<input type='tel' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        
        $res .="value='".$this->model->$name."'";
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute un input checkbox
    * @param String $name name de l'input
    * @param String $value 
    * @param Boolean $checked bouton coché ou non
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputCheckbox($name, $value, $checked=false, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }
        $res .= "<input type='checkbox' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        $res .="value='".$value."'";
        if($checked) {
            $res .= " checked";
        }
        $res .="/>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }


    /**
    * Ajoute un textarea
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function textarea($name, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }

        $res .= "<textarea id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
       
        $res .= "/>\n";
        $res .= $this->model->$name;
        $res .= "</textarea>\n";

        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute bouton submit
    * @param String $value
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function submit($value,$htmlOptions=array())
    {
        $res = "";  
        $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
        $htmlOptions['class'] .= " button";
        $res .= "<input type='submit'  ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        $res .="value='".$value."'";
        $res .="/>\n";
        return $res;
    }

    /**
    * Ajoute un bouton 
    * @param String $name name de l'input
    * @param String $value
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function button($name,$value,$htmlOptions=array())
    {
        $res = "";  
        $res .= "<input type='button' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        $res .="value='".$value."'";
        $res .="/>\n";
        return $res;
    }

    /**
    * Ajoute un input radio
    * @param String $name name de l'input
    * @param String $value
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function inputRadio($name, $value, $htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }
        $res .= "<input type='radio' id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        $res .="value='".$value."'";
        $res .="/>\n";
        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        }
        return $res;
    }

    /**
    * Ajoute select 
    * @param String $name name de l'input
    * @param Array $htmlOptions 
    * @return String $res
    */
    public function selectOption($name, $options,$htmlOptions=array())
    {
        $res = "";  
        if(isset($this->model->getErrors()[$name])) {
            $htmlOptions['class'] = isset($htmlOptions["class"])? $htmlOptions["class"] : "";
            $htmlOptions['class'] .= " error";
        }
        $res .= "<select id='".$name."' name='".$name."' ";
        foreach ($htmlOptions as $option => $valeur) {
            $res .= $option."='".$valeur."' ";
        }
        $res .= ">\n";
        foreach ($options as $value => $content) {
            $res .= "<option value='".$value."' >".$content."</option>\n";
        }
        $res .= "</seclect>\n";
        if(isset($this->model->getErrors()[$name])) {
            $res .= "<small class='error'>".$this->model->getErrors()[$name]."</small>\n";
        } 
        return $res;
    }
}

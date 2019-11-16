<?php

class CommandHandler{

  private $accounts = array('administrator' => 'purkiada2016', 'agent' => 'securePassword123');

  public function __construct($inputValue){

  	$input = explode(" ", $inputValue);

  	switch($input[0]){
  		case 'help':
  			echo($this->help());
  		break;
  		case 'login':
        if(empty($input[1]) || empty($input[2])){
          echo($this->returnText("Nebyly zadány žádné přihlašovací údaje.", "login"));
        } else {
  			  echo($this->login($input[1], $input[2]));
        }
  		break;
  		case 'logout':
  			echo($this->logout());
  		break;
      case 'ls':
        echo($this->lsCommand());
      break;
      case 'cd':
        if(isset($input[1])){
          echo($this->cdCommand($input[1]));
        } else {
          echo($this->cdCommand("empty"));
        }
      break;
      case 'read':
        if(isset($input[1])){
          echo($this->readCommand($input[1]));
        } else {
          echo($this->returnText("Nebyl zadán název souboru.", "read"));
        }
      break;
  		default:
  			echo($this->returnText('Příkaz nebyl nalezen!', "Not found"));
  		break;
  	}
  }

  public function isLoggedIn(){
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
      return 1;
    } else {
      return 0;
    }
  }

  public function login($nickname, $password){
  	if(isset($nickname) && isset($password)){
	  	if(isset($this->accounts[$nickname])){
	  		if($this->accounts[$nickname] == $password){
	  			$_SESSION['loggedIn'] = true;
	  			$_SESSION['nickname'] = $nickname;
          $_SESSION['path'] = "~#";
          $randomNumber = rand(100000, 999999);
          $_SESSION['randomNumber'] = $randomNumber;
	  			return $this->returnText("Byl jsi úspěšně přihlášen jako " . $_SESSION['nickname'] . ".", "login");
	  		} else {
	  			return $this->returnText("Bylo zadáno špatné heslo.", "login");
	  		}
	  	} else {
	  		return $this->returnText("Uživatel nebyl nalezen.", "login");
	  	}
	  }
  }

  public function logout(){
  	if($this->isLoggedIn()){
  		$_SESSION['loggedIn'] = NULL;
  		$_SESSION['nickname'] = NULL;
      $_SESSION['path'] = NULL;

  		return $this->returnText("Byl jsi úspěšně odhlášen.", "logout");
  	} else {
  		return $this->returnText("Nemůžeš se odhlásit, pokud si nebyl přihlášen.", "logout");
  	}
  }

  public function help(){
    return $this->returnText('
    	Dostupné příkazy:<br>
      cd &lt;folder_name&gt; - přesun do jiné složky(pokud vynecháno, vrátí do defaultní, dvě tečky vrátí o složku nahoru)<br>
      read &lt;file_name&gt; - vyčte obsah souboru<br>
      help - vypíše nápovědu<br>
    	login &lt;nickname&gt; &lt;password&gt; - příhlásí uživatele<br>
    	logout - odhlásí uživatele<br>
      ls - vypíše seznam souborů/složek  
    	', "help");
  }

  public function readCommand($file){
    if($_SESSION['path'] == "/home#"){
      if($file == "login.data"){
        return $this->returnText("
          200ceb26807d6bf99fd6f4f0d1ca54d4:42aa55835bca9c1346f93a8e6fe76d7a<br>
          b33aed8f3134996703dc39f9a7c95783:23ed94b25c374afb59453551a38ec44b
          ", "read");
      } else {
        return $this->returnText("Soubor nebyl nalezen.", "read");
      }
    } elseif($_SESSION['path'] == "/home/administrator#"){
      if($file == "data.txt"){
        return $this->returnText("
          Dokázal jste se dostat až na konec agente! Do záznamového archu zapiš číslo: " . $_SESSION['randomNumber'] . "", "read");
      } else { 
        return $this->returnText("Soubor nebyl nalezen.", "read");
      }
    } else {
      return $this->returnText("Soubor nebyl nalezen.", "read");
    }
  }

  public function lsCommand(){
    if($this->isLoggedIn()){
      if($_SESSION['path'] == "/home#"){
        return $this->returnText('
          administrator/<br>
          agent/<br>
          login.data
          ', "ls");
      } elseif($_SESSION['path'] == "/home/administrator#"){
        return $this->returnText('
          data.txt<br>
          ', "ls");
      } elseif($_SESSION['path'] == "/home/agent#"){
        return $this->returnText('V téhle složce se nenachází žádné soubory.', "ls");
      } else {
        return $this->returnText('
          bin/<br>
          boot/<br>
          dev/<br>
          etc/<br>
          home/<br>
          lib/<br>
          media/
          ', "ls");
      }
    } else {
      return $this->returnText("K použití tohoto příkazu musíš být přihlášen.", "ls");
    }
  }

  public function cdCommand($directory){
    if($this->isLoggedIn()){

      /* HOME FOLDER */
      if($_SESSION['path'] == '/home#'){
        if($directory == "administrator"){
          if($_SESSION['nickname'] == "administrator"){
            $_SESSION['path'] = "/home/administrator#";
            return $this->returnText("", "cd");
          } else {
            return $this->returnText("Nemáš přístup do této složky.", "cd");
          }
        } elseif($directory == "agent"){
          if($_SESSION['nickname'] == "agent" || $_SESSION['nickname'] == "administrator"){
            $_SESSION['path'] = "/home/agent#";
            return $this->returnText("", "cd");
          } else {
            return $this->returnText("Do této složky nemáš přístup.", "cd");
          }
        } elseif($directory == ".." && $_SESSION['path'] == "/home#"){
            $_SESSION['path'] = "~#";
            return $this->returnText("", "cd"); 
        } else {
           return $this->returnText("Zadán špatný název složky.", "cd");
        }
      }
      /* DEFAULT */
      if($directory == "empty"){
        $_SESSION['path'] = "~#";
        return $this->returnText("", "cd");
      } elseif($directory == "home"){
        $_SESSION['path'] = "/home#";
        return $this->returnText("", "cd");
      } elseif($directory == ".." && $_SESSION['path'] == "/home/agent#" || $_SESSION['path'] == "/home/administrator#"){
        $_SESSION['path'] = "/home#";
        return $this->returnText("", "cd"); 
      } elseif($directory == "bin" || $directory == "boot" || $directory == "dev" || $directory == "etc" || $directory == "lib" || $directory == "media") {
        return $this->returnText("Do této složky nemáš přístup.", "cd");
      } else {
        return $this->returnText("Složka nebyla nalezena.", "cd");
      }
    } else {
    return $this->returnText("K použití tohoto příkazu musíš být přihlášen.", "cd");
  }
}

  public function returnText($text, $command){
  	if($this->isLoggedIn()){
  		$location = $_SESSION['nickname'] . '@pc' . $_SESSION['path'];
  	} else {
  		$location = '>';
  	}

  	return '
    <div class="return">
      <p><span>'. $command . '</span><br>' . $text . '</p>
      <span>' . $location . '</span>
      <input type="text" id="input" name="input" autofocus="1">
    </div>';
  }
}
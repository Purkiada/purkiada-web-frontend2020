<?php
session_start();

require('./class/CommandHandler.class.php');

if(isset($_GET['input'])){
  $commandHandler = new CommandHandler($_GET['input']);
}
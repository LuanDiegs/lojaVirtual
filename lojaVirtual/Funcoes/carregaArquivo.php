<?php

  function carregaArquivo($arquivo){
      switch ($arquivo["error"]) {
    case UPLOAD_ERR_OK:
        return true;
        break;
    case UPLOAD_ERR_INI_SIZE:
        
    case UPLOAD_ERR_FORM_SIZE:
        
    case UPLOAD_ERR_PARTIAL:
        
    case UPLOAD_ERR_NO_FILE:
        
    case UPLOAD_ERR_NO_TMP_DIR:
        
    case UPLOAD_ERR_CANT_WRITE:
        
    case UPLOAD_ERR_EXTENSION:
        
        return false;
    default:
        break;
    }
  }
  
  function movearquivo($arquivo,$nome){
      move_uploaded_file($arquivo["tmp_name"],$nome);
  }
  
  function carregaImagem($nome){
      $arquivo = "res/img/padrao.jpg";
      
      if (file_exists($nome)){
          $arquivo = $nome;
          
      }
      
      return $arquivo;
  }
?>
  

<?php
  $val1=rand();
  $val2=rand();
  echo substr(base64_encode($val1.$val2), 0, 8);
?>
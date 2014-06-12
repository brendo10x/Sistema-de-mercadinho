<?php
//configura pesquisa
if (!empty($busca)) {
    $this -> paginator -> options(array('url' => array($tipo, $busca)));
}
?>

<?php

echo rawurldecode($this -> paginator -> first(__('Primeiro'), array('tag' => 'li', 'disabledTag' => 'a'), null, array('class' => 'active', 'tag' => 'li', 'disabledTag' => 'a')));

echo rawurldecode($this -> paginator -> prev(__('Anterior'), array('tag' => 'li', 'disabledTag' => 'a'), null, array('class' => 'active', 'tag' => 'li', 'disabledTag' => 'a')));

echo rawurldecode($this -> paginator -> numbers(array('separator' => '', 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'modulus' => $modulus)));

echo rawurldecode($this -> paginator -> next(__('Próximo'), array('tag' => 'li', 'disabledTag' => 'a'), null, array('class' => 'active', 'tag' => 'li', 'disabledTag' => 'a')));

echo rawurldecode($this -> paginator -> last(__('Último'), array('tag' => 'li', 'disabledTag' => 'a'), null, array('class' => 'active', 'tag' => 'li', 'disabledTag' => 'a')));
?>
<?php

final class ArcanistUserRef
  extends ArcanistRef
  implements
    ArcanistDisplayRefInterface {

  private $parameters;

  public function getRefDisplayName() {
    return pht('User "%s"', $this->getUsername());
  }

  public static function newFromConduit(array $parameters) {
    $ref = new self();
    $ref->parameters = $parameters;
    return $ref;
  }

  public static function newFromConduitWhoami(array $parameters) {
    // NOTE: The "user.whoami" call returns a different structure than
    // "user.search". Mangle the data so it looks similar.

    $parameters['fields'] = array(
      'username' => idx($parameters, 'userName'),
      'realName' => idx($parameters, 'realName'),
    );

    return self::newFromConduit($parameters);
  }

  public function getUsername() {
    return idxv($this->parameters, array('fields', 'username'));
  }

  public function getRealName() {
    return idxv($this->parameters, array('fields', 'realName'));
  }

  public function getDisplayRefObjectName() {
    return '@'.$this->getUsername();
  }

  public function getDisplayRefTitle() {
    $real_name = $this->getRealName();

    if (strlen($real_name)) {
      $real_name = sprintf('(%s)', $real_name);
    }

    return $real_name;
  }

}

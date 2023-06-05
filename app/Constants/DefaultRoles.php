<?php

namespace App\Constants;

class DefaultRoles
{
   
   const ADMIN = 'Admin';
   const PROVIDER = 'Provider';
   const DRIVER = 'Driver';
   const CUSTOMER = 'Customer';
   const UNVERIFIED = 'Unverified';
 
   public function getConstants()
   {
      $reflectionClass = new \ReflectionClass($this);
      return $reflectionClass->getConstants();
   }

   public function hasConstant($constans)
   {
      $reflectionClass = new \ReflectionClass($this);
      return $reflectionClass->hasConstant($constans);
   }
   
}

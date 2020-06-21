<!DOCTYPE html>
<!-- Made with 🔥 and 🤘🏼 by 730. -->

<html <?php language_attributes(); ?>>

<head> 
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <title><?php wp_title(" | ", TRUE, "RIGHT"); ?></title>

  <?php wp_head(); ?>  
  
<!-- 
  INSERT TAG MANAGER HEAD CODE HERE
-->

</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
  wp_body_open();
} else {
  do_action( 'wp_body_open' );
}
?>

<!-- 
  INSERT TAG MANAGER BODY CODE HERE
-->

<div>
  <header>
    <nav>

    </nav>
  </header>
</div>
  


<?php
return function ($option)
{
  global $menus;
  $menus = WpThemeConfig\Configurator::getInstance()->get('core.menu-items');
  function floating_menu()
  {
    global $menus;

    // $url = plugins_url('/', __FILE__).'assets/mtrlfm.min.js';
    // wp_deregister_script('mtrl-floatingmenu-js');
    // wp_register_script('mtrl-floatingmenu-js', $url);
    // wp_enqueue_script('mtrl-floatingmenu-js','jquery');

    // $url = plugins_url('/', __FILE__).'assets/mtrlfm.css';
    // wp_deregister_style('mtrl-floatingmenu-css');
    // wp_register_style('mtrl-floatingmenu-css', $url);
    // wp_enqueue_style('mtrl-floatingmenu-css');

    $floateffect = "slidein";
    if(isset($menus['effect']) && trim($menus['effect']) != ""){
      $floateffect = $menus['effect'];
    }

    $floatpos = "br";
    if(isset($menus['position']) && trim($menus['position']) != ""){
      $floatpos = $menus['position'];
    }

    $floatopen = "hover";
    if(isset($menus['event']) && trim($menus['event']) != ""){
      $floatopen = $menus['event'];
    }
    ?>

    <ul id="mtrl-floatingmenu" class="fmenu fmenu--<?php echo $floatpos; ?> mtrlfm-<?php echo $floateffect; ?>" data-mtrlfm-toggle="<?php echo $floatopen; ?>">
      <li class="fmenu__wrap">
        <a href="#" class="fmenu__button--main">
          <i class="fmenu__main-icon--resting dashicons-before dashicons-marker"></i>
          <i class="fmenu__main-icon--active dashicons-before dashicons-no-alt"></i>
        </a>
        <ul class="fmenu__list">
          <?php foreach ($menus['links'] as $key => $link) {
            echo "<li><a href='".$link['url']."' class='fmenu__button--child'><i class='fmenu__child-icon ".$link['icon']."'></i></a><span data-mtrlfm-label='".$link['title']."'></span></li>";
          }?>
        </ul>
      </li>
    </ul>
    <?php
  }
  
  add_action('admin_footer', 'floating_menu', 1);
};
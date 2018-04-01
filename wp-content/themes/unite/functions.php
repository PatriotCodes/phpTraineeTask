<?php
/**
 * _s functions and definitions
 *
 * @package unite
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 730; /* pixels */
}

/**
 * Set the content width for full width pages with no sidebar.
 */
function unite_content_width() {
  if ( is_page_template( 'page-fullwidth.php' ) || is_page_template( 'front-page.php' ) ) {
    global $content_width;
    $content_width = 1110; /* pixels */
  }
}
add_action( 'template_redirect', 'unite_content_width' );


if ( ! function_exists( 'unite_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function unite_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change 'unite' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'unite', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'unite-featured', 730, 410, true );
	add_image_size( 'tab-small', 60, 60 , true); // Small Thumbnail

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'unite' ),
		'footer-links' => __( 'Footer Links', 'unite' ) // secondary nav in footer
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'unite_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add WooCommerce support
	add_theme_support( 'woocommerce' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

}
endif; // unite_setup
add_action( 'after_setup_theme', 'unite_setup' );

if ( ! function_exists( 'movies_post' ) ) {
 
// Опишем требуемый функционал
    function movies_post() {
 
        $labels = array(
            'name'                => _x( 'Фильмы', 'Post Type General Name', 'movies' ),
            'singular_name'       => _x( 'Фильм', 'Post Type Singular Name', 'movies' ),
            'menu_name'           => __( 'Фильмы', 'movies' ),
            'parent_item_colon'   => __( 'Родительский:', 'movies' ),
            'all_items'           => __( 'Все записи', 'movies' ),
            'view_item'           => __( 'Просмотреть', 'movies' ),
            'add_new_item'        => __( 'Добавить новую запись в Фильмы', 'movies' ),
            'add_new'             => __( 'Добавить новую', 'movies' ),
            'edit_item'           => __( 'Редактировать запись', 'movies' ),
			'menu_icon'           => __( 'dashicons-format-video', 'movies' ),
            'update_item'         => __( 'Обновить запись', 'movies' ),
            'search_items'        => __( 'Найти запись', 'movies' ),
            'not_found'           => __( 'Не найдено', 'movies' ),
            'not_found_in_trash'  => __( 'Не найдено в корзине', 'movies' ),
        );
        $args = array(
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail'),
            'taxonomies'          => array( 'movies_tax' ), // категории, которые мы создадим ниже
            'public'              => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-book',
        );
        register_post_type( 'movies', $args );
 
    }
 
    add_action( 'init', 'movies_post', 0 ); // инициализируем
 
}

if ( ! function_exists( 'movies_tax' ) ) {
 
// Опишем требуемый функционал
    function movies_tax() {
 
        $labels = array(
            'name'                       => _x( 'Категории Фильмов', 'Taxonomy General Name', 'movies' ),
            'singular_name'              => _x( 'Категория Фильма', 'Taxonomy Singular Name', 'movies' ),
            'menu_name'                  => __( 'Категории', 'movies' ),
            'all_items'                  => __( 'Категории', 'movies' ),
            'parent_item'                => __( 'Родительская категория Фильмов', 'movies' ),
            'parent_item_colon'          => __( 'Родительская категория Фильмов:', 'movies' ),
            'new_item_name'              => __( 'Новая категория', 'movies' ),
            'add_new_item'               => __( 'Добавить новую категорию', 'movies' ),
            'edit_item'                  => __( 'Редактировать категорию', 'movies' ),
            'update_item'                => __( 'Обновить категорию', 'movies' ),
            'search_items'               => __( 'Найти', 'movies' ),
            'add_or_remove_items'        => __( 'Добавить или удалить категорию', 'movies' ),
            'choose_from_most_used'      => __( 'Поиск среди популярных', 'movies' ),
            'not_found'                  => __( 'Не найдено', 'movies' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
        );
        register_taxonomy( 'movies_tax', array( 'movies' ), $args );
 
    }
 
    add_action( 'init', 'movies_tax', 0 ); // инициализируем
 
}

function movies_meta_box() {  
    add_meta_box(  
        'movies_meta_box', // Идентификатор(id)
        'Фильмы - дополнительная информация', // Заголовок области с мета-полями(title)
        'show_my_movies_metabox', // Вызов(callback)
        'movies', // Где будет отображаться наше поле, в нашем случае в разделе Красная Книга
        'normal',
        'high');
}  
add_action('add_meta_boxes', 'movies_meta_box'); // Запускаем функцию

$movies_meta_fields = array(
    array(  
        'label' => 'Стоимость сеанса',  
        'desc'  => '',  
        'id'    => 'order', // даем идентификатор.
        'type'  => 'text'  // Указываем тип поля.
    ),  
    array(  
        'label' => 'Дата выхода',  
        'desc'  => '',  
        'id'    => 'kind',  // даем идентификатор.
        'type'  => 'date'  // Указываем тип поля.
    )
);

function show_my_movies_metabox() {  
global $movies_meta_fields; // Обозначим наш массив с полями глобальным
global $post;  // Глобальный $post для получения id создаваемого/редактируемого поста
// Выводим скрытый input, для верификации. Безопасность прежде всего!
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
 
    // Начинаем выводить таблицу с полями через цикл
    echo '<table class="form-table">';  
    foreach ($movies_meta_fields as $field) {  
        // Получаем значение если оно есть для этого поля
        $meta = get_post_meta($post->ID, $field['id'], true);  
        // Начинаем выводить таблицу
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';  
                switch($field['type']) {  
                    // Текстовое поле
					case 'text':  
					    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
					        <br /><span class="description">'.$field['desc'].'</span>';  
					break;
					case 'date':
						echo '<input type="date" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
					        <br /><span class="description">'.$field['desc'].'</span>';  
					break;
                }
        echo '</td></tr>';  
    }  
    echo '</table>';
}

function save_my_movies_meta_fields($post_id) {  
    global $movies_meta_fields;  // Массив с нашими полями
 
    // проверяем наш проверочный код
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))  
        return $post_id;  
    // Проверяем авто-сохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
        return $post_id;  
    // Проверяем права доступа  
    if ('movies' == $_POST['post_type']) {  
        if (!current_user_can('edit_page', $post_id))  
            return $post_id;  
        } elseif (!current_user_can('edit_post', $post_id)) {  
            return $post_id;  
    }  
 
    // Если все отлично, прогоняем массив через foreach
    foreach ($movies_meta_fields as $field) {  
        $old = get_post_meta($post_id, $field['id'], true); // Получаем старые данные (если они есть), для сверки
        $new = $_POST[$field['id']];  
        if ($new && $new != $old) {  // Если данные новые
            update_post_meta($post_id, $field['id'], $new); // Обновляем данные
        } elseif ('' == $new && $old) {  
            delete_post_meta($post_id, $field['id'], $old); // Если данных нету, удаляем мету.
        }  
    } // end foreach  
}  
add_action('save_post', 'save_my_movies_meta_fields'); // Запускаем функцию сохранения

function last5movies() {
	$movies_args = array(
  		'numberposts' => 5,
  		'post_type'   => 'movies'
	);
	$latest_movies = get_posts( $movies_args );
	foreach($latest_movies as $post) {
		setup_postdata($post);
		echo '<h2><a href="';
		echo get_permalink($post->ID);
		echo '">';
		echo get_the_title($post->ID);
		echo '</a></h2>';
        echo the_content();
	}
    wp_reset_postdata($post);
}

// SHORT CODE:
add_shortcode( 'movies_last', 'last5movies' );

if ( ! function_exists( 'unite_widgets_init' ) ) :
/**
 * Register widgetized area and update sidebar with default widgets.
 */
function unite_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'unite' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar(array(
		'id'            => 'home1',
		'name'          => 'Homepage Widget 1',
		'description'   => 'Used only on the homepage page template.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
    ));

    register_sidebar(array(
		'id'            => 'home2',
		'name'          => 'Homepage Widget 2',
		'description'   => 'Used only on the homepage page template.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
    ));

    register_sidebar(array(
		'id'            => 'home3',
		'name'          => 'Homepage Widget 3',
		'description'   => 'Used only on the homepage page template.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
    ));

    register_widget( 'unite_popular_posts_widget' );
    register_widget( 'unite_social_widget' );
}
endif;
add_action( 'widgets_init', 'unite_widgets_init' );

/**
 * Include widgets for Unite theme
 */
include(get_template_directory() . "/inc/widgets/popular-posts-widget.php");
include(get_template_directory() . "/inc/widgets/widget-social.php");

/**
 * Include Metabox for Unite theme
 */
include(get_template_directory() . "/inc/metaboxes.php");



if ( ! function_exists( 'unite_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function unite_scripts() {

	wp_enqueue_style( 'unite-bootstrap', get_template_directory_uri() . '/inc/css/bootstrap.min.css' );

	wp_enqueue_style( 'unite-icons', get_template_directory_uri().'/inc/css/font-awesome.min.css' );

	wp_enqueue_style( 'unite-style', get_stylesheet_uri() );

	wp_enqueue_script('unite-bootstrapjs', get_template_directory_uri().'/inc/js/bootstrap.min.js', array('jquery') );

	wp_enqueue_script( 'unite-functions', get_template_directory_uri() . '/inc/js/main.min.js', array('jquery') );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'unite_scripts' );


if ( ! function_exists( 'unite_ie_support_header' ) ) :
/**
 * Add HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries
 */
function unite_ie_support_header() {
    echo '<!--[if lt IE 9]>'. "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/inc/js/html5shiv.min.js' ) . '"></script>'. "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/inc/js/respond.min.js' ) . '"></script>'. "\n";
    echo '<![endif]-->'. "\n";
}
endif;
add_action( 'wp_head', 'unite_ie_support_header', 1 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom nav walker
 */

require get_template_directory() . '/inc/navwalker.php';

/**
 * Load social nav
 */
require get_template_directory() . '/inc/socialnav.php';

/* All Globals variables */
global $text_domain;
$text_domain = 'unite';

global $site_layout;
$site_layout = array('side-pull-left' => esc_html__('Right Sidebar', 'dazzling'),'side-pull-right' => esc_html__('Left Sidebar', 'dazzling'),'no-sidebar' => esc_html__('No Sidebar', 'dazzling'),'full-width' => esc_html__('Full Width', 'dazzling'));

// Option to switch between the_excerpt and the_content
global $blog_layout;
$blog_layout = array('1' => __('Display full content for each post', 'unite'),'2' => __('Display excerpt for each post', 'unite'));

// Typography Options
global $typography_options;
$typography_options = array(
        'sizes' => array( '6px' => '6px','10px' => '10px','12px' => '12px','14px' => '14px','15px' => '15px','16px' => '16px','18'=> '18px','20px' => '20px','24px' => '24px','28px' => '28px','32px' => '32px','36px' => '36px','42px' => '42px','48px' => '48px' ),
        'faces' => array(
                'arial'          => 'Arial',
                'verdana'        => 'Verdana, Geneva',
                'trebuchet'      => 'Trebuchet',
                'georgia'        => 'Georgia',
                'times'          => 'Times New Roman',
                'tahoma'         => 'Tahoma, Geneva',
                'Open Sans'      => 'Open Sans',
                'palatino'       => 'Palatino',
                'helvetica'      => 'Helvetica',
                'helvetica-neue' => 'Helvetica Neue,Helvetica,Arial,sans-serif'
        ),
        'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
        'color'  => true
);

/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 */
if ( ! function_exists( 'of_get_option' ) ) :
function of_get_option( $name, $default = false ) {

  $option_name = '';
  // Get option settings from database
  $options = get_option( 'unite' );

  // Return specific option
  if ( isset( $options[$name] ) ) {
    return $options[$name];
  }

  return $default;
}
endif;
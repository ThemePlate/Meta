# ThemePlate Meta

## Usage

```php
use ThemePlate\Meta;

$args = array(
	'id'     => 'test-meta',
	'title'  => 'Tester',
	'fields' => array(),
	// 'show_on'  => array(),
	// 'hide_on'  => array(),
	// 'priority' => 'default',
);
```

### Post Type
```php
$args['screen']  = array( 'post', 'page' );
$args['context'] = array( 'advanced' );

new Meta\Post( $args );
```

### Taxonomy Term
```php
$args['taxonomy'] = array( 'category', 'post_tag' );

new Meta\Term( $args );
```

### WP User
```php
new Meta\User( $args );
```

### Nav Menu Item
```php
new Meta\User( $args );
```

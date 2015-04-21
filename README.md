# laravel-tweaks-paginator
Changes default Laravel pagination data

Default Laravel pagination is unusable if you use non-PHP-based templates. Your model still will provide some pagination data if you use paginate() in Eloquent calls, but this data is rather incomplete and it overrides any HTTP GET params you might need.

This is a really simple class that gives you an array with correct URLs for next, last, previous and first pages while keeping other GET params intact. Currently it only works with arrays returned by Eloquent's toArray().

It should be placed in app/Services and called from your model:

$query_data = $this->some_eloquent_methods_go_here()->paginate($posts_on_page)->toArray();
$paginator = new Paginator($query_data['current_page'], $query_data['last_page']);
$pagination_links = $paginator->getPaginationLinks();

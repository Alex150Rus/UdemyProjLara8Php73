php artisan db:seed - to refresh database  
php artisan tinker - to practice  

### Cache
Cache::put('key', 'anything') : stored forever  
Cache::put('key', 'anything', 5) : stored for 5 minutes  
Cache::has('key') : check if data exists in cache and returns bool
Cache::get('key') : null|string
Cache::get('key2', 'default value') : 'default value'  
Cache::increment('counter');  
Cache::decrement();  

### Model
php artisan make:model Tag

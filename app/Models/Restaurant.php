<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Restaurant extends Model
    {
        use HasFactory;

        protected $fillable = ['name', 'location', 'rating'];

        /**
         * Get the dishes for the restaurant.
         */
        public function dishes(): HasMany
        {
            return $this->hasMany(Dish::class);  // Assuming Dish has a 'restaurant_id' foreign key
        }
    }
    
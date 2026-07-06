<?php

namespace Database\Seeders;

use App\Models\PackageCategory;
use App\Models\SafariPackage;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run role and permission seeder first
        $this->call(RolePermissionSeeder::class);

        // Create default users
        $this->createUsers();

        // Create package categories
        $this->createPackageCategories();

        // Create destinations
        $this->createDestinations();

        // Create sample packages
        $this->createPackages();
    }

    private function createUsers()
    {
        // Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@safaritours.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'phone' => '+254700000000',
                'country' => 'Kenya',
                'is_active' => true,
            ]
        );
        $admin->assignRole('super_admin');

        // Sales Agent
        $agent = User::firstOrCreate(
            ['email' => 'sales@safaritours.com'],
            [
                'name' => 'Sales Agent',
                'password' => Hash::make('password'),
                'phone' => '+254700000001',
                'country' => 'Kenya',
                'is_active' => true,
            ]
        );
        $agent->assignRole('sales_agent');

        // Regular Customer
        $customer = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'phone' => '+254700000002',
                'country' => 'Kenya',
                'is_active' => true,
            ]
        );
        $customer->assignRole('customer');
    }

    private function createPackageCategories()
    {
        PackageCategory::firstOrCreate(
            ['slug' => 'budget-safaris'],
            [
                'name' => 'Budget Safaris',
                'description' => 'Affordable safari options for budget-conscious travelers',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        PackageCategory::firstOrCreate(
            ['slug' => 'mid-range-safaris'],
            [
                'name' => 'Mid-Range Safaris',
                'description' => 'Comfortable safari experiences at reasonable prices',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        PackageCategory::firstOrCreate(
            ['slug' => 'luxury-safaris'],
            [
                'name' => 'Luxury Safaris',
                'description' => 'Premium safari experiences with luxury accommodations',
                'is_active' => true,
                'sort_order' => 3,
            ]
        );
    }

    private function createDestinations()
    {
        $masaiMara = Destination::firstOrCreate(
            ['slug' => 'masai-mara-national-reserve'],
            [
                'name' => 'Masai Mara National Reserve',
                'description' => 'Famous for the annual Great Migration of wildebeest, zebra, and gazelle.',
                'country' => 'Kenya',
                'region' => 'Rift Valley',
                'latitude' => -1.5194,
                'longitude' => 35.1728,
                'best_time_to_visit' => 'July to October',
                'wildlife' => ['Lions', 'Elephants', 'Leopards', 'Cheetahs', 'Wildebeest', 'Zebras'],
                'activities' => ['Game drives', 'Hot air balloon safaris', 'Walking safaris'],
                'is_featured' => true,
                'status' => 'active',
                'views_count' => 2500,
            ]
        );

        $serengeti = Destination::firstOrCreate(
            ['slug' => 'serengeti-national-park'],
            [
                'name' => 'Serengeti National Park',
                'description' => 'Tanzania\'s oldest and most popular national park, a UNESCO World Heritage Site.',
                'country' => 'Tanzania',
                'region' => 'Northern Tanzania',
                'latitude' => -2.1540,
                'longitude' => 34.6857,
                'best_time_to_visit' => 'June to October',
                'wildlife' => ['Lions', 'Elephants', 'Wildebeest', 'Zebras', 'Giraffes'],
                'activities' => ['Game drives', 'Walking safaris', 'Cultural visits'],
                'is_featured' => true,
                'status' => 'active',
                'views_count' => 1800,
            ]
        );

        $amboseli = Destination::firstOrCreate(
            ['slug' => 'amboseli-national-park'],
            [
                'name' => 'Amboseli National Park',
                'description' => 'Known for its large elephant herds and spectacular views of Mount Kilimanjaro.',
                'country' => 'Kenya',
                'region' => 'Eastern Kenya',
                'latitude' => -2.6467,
                'longitude' => 37.2508,
                'best_time_to_visit' => 'June to October',
                'wildlife' => ['Elephants', 'Lions', 'Zebras', 'Wildebeest'],
                'activities' => ['Game drives', 'Cultural visits'],
                'is_featured' => false,
                'status' => 'active',
                'views_count' => 1200,
            ]
        );
    }

    private function createPackages()
    {
        $categories = PackageCategory::all();
        $destinations = Destination::all();

        // 7-Day Masai Mara Safari
        $package1 = SafariPackage::firstOrCreate(
            ['slug' => '7-day-masai-mara-safari'],
            [
                'category_id' => $categories->where('slug', 'mid-range-safaris')->first()->id,
                'title' => '7-Day Masai Mara Safari',
                'short_desc' => 'Experience the magic of the Masai Mara with this 7-day safari adventure.',
                'full_desc' => 'Experience the magic of the Masai Mara with our comprehensive 7-day safari adventure. This package includes game drives, cultural visits, and comfortable accommodation.',
                'duration' => 7,
                'price' => 2500.00,
                'currency' => 'USD',
                'location' => 'Masai Mara, Kenya',
                'highlights' => ['Game drives in Masai Mara', 'Hot air balloon ride', 'Visit to Maasai village', 'Luxury accommodation'],
                'inclusions' => ['Accommodation for 6 nights', 'All meals', 'Transport in 4x4 safari vehicle', 'Professional guide'],
                'exclusions' => ['International flights', 'Travel insurance', 'Personal expenses'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'meta_title' => '7-Day Masai Mara Safari - Best Safari Experience',
                'meta_description' => 'Experience the best of Masai Mara with our 7-day safari package.',
                'views_count' => 1250,
                'enquiries_count' => 45,
            ]
        );
        if (!$package1->destinations()->where('slug', 'masai-mara-national-reserve')->exists()) {
            $package1->destinations()->attach($destinations->where('slug', 'masai-mara-national-reserve')->first()->id);
        }

        // 5-Day Amboseli Safari
        $package2 = SafariPackage::firstOrCreate(
            ['slug' => '5-day-amboseli-safari'],
            [
                'category_id' => $categories->where('slug', 'budget-safaris')->first()->id,
                'title' => '5-Day Amboseli Safari',
                'short_desc' => 'Experience Amboseli\'s elephants and Mount Kilimanjaro views.',
                'full_desc' => 'Discover the beauty of Amboseli National Park with our 5-day safari. Witness large elephant herds against the backdrop of Mount Kilimanjaro.',
                'duration' => 5,
                'price' => 1800.00,
                'currency' => 'USD',
                'location' => 'Amboseli National Park, Kenya',
                'highlights' => ['Elephant viewing', 'Mount Kilimanjaro views', 'Cultural visits'],
                'inclusions' => ['Accommodation', 'Meals', 'Transport', 'Guide'],
                'exclusions' => ['Flights', 'Insurance', 'Personal expenses'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'meta_title' => '5-Day Amboseli Safari',
                'meta_description' => 'Amazing Amboseli safari experience with Kilimanjaro views.',
                'views_count' => 980,
                'enquiries_count' => 32,
            ]
        );
        if (!$package2->destinations()->where('slug', 'amboseli-national-park')->exists()) {
            $package2->destinations()->attach($destinations->where('slug', 'amboseli-national-park')->first()->id);
        }

        // 10-Day Tanzania Safari
        $package3 = SafariPackage::firstOrCreate(
            ['slug' => '10-day-luxury-tanzania-safari'],
            [
                'category_id' => $categories->where('slug', 'luxury-safaris')->first()->id,
                'title' => '10-Day Luxury Tanzania Safari',
                'short_desc' => 'Ultimate luxury safari experience covering Serengeti, Ngorongoro, and Tarangire.',
                'full_desc' => 'Experience Tanzania\'s premier safari destinations in ultimate luxury. This 10-day package covers Serengeti, Ngorongoro Crater, and Tarangire National Park.',
                'duration' => 10,
                'price' => 4500.00,
                'currency' => 'USD',
                'location' => 'Northern Tanzania',
                'highlights' => ['Luxury accommodations', 'Private guide', 'Serengeti migration', 'Ngorongoro Crater'],
                'inclusions' => ['Luxury accommodation', 'All meals', 'Private 4x4 vehicle', 'Professional guide', 'Domestic flights'],
                'exclusions' => ['International flights', 'Travel insurance', 'Alcoholic beverages'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'meta_title' => '10-Day Luxury Tanzania Safari',
                'meta_description' => 'Ultimate luxury safari experience in Tanzania.',
                'views_count' => 750,
                'enquiries_count' => 28,
            ]
        );
        if (!$package3->destinations()->where('slug', 'serengeti-national-park')->exists()) {
            $package3->destinations()->attach($destinations->where('slug', 'serengeti-national-park')->first()->id);
        }
    }
}

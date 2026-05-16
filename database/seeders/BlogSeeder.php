<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $travelTipsCategory = BlogCategory::where('slug', 'travel-tips')->first();
        $culturalCategory = BlogCategory::where('slug', 'cultural-heritage')->first();
        $wildlifeCategory = BlogCategory::where('slug', 'wildlife-nature')->first();
        $adventureCategory = BlogCategory::where('slug', 'adventure-activities')->first();
        $foodCategory = BlogCategory::where('slug', 'food-cuisine')->first();

        $blogs = [
            [
                'blog_category_id' => $travelTipsCategory->id,
                'title' => 'Essential Travel Tips for First-Time Visitors to Sri Lanka',
                'slug' => 'essential-travel-tips-first-time-visitors-sri-lanka',
                'excerpt' => 'Planning your first trip to Sri Lanka? Here are the essential travel tips you need to know for an unforgettable experience.',
                'content' => '<p>Sri Lanka, the "Pearl of the Indian Ocean," is a tropical paradise that offers incredible diversity in a compact island. From pristine beaches to ancient temples, lush tea plantations to wildlife safaris, this beautiful country has something for every traveler.</p>

<h3>Best Time to Visit</h3>
<p>The best time to visit Sri Lanka depends on which part of the island you plan to explore. The southwest coast (including Colombo, Galle, and Mirissa) is best visited from December to March, while the northeast coast (including Trincomalee and Arugam Bay) is ideal from April to September.</p>

<h3>Getting Around</h3>
<p>Sri Lanka offers various transportation options. Trains provide scenic journeys, especially the famous Kandy to Ella route. Buses are economical but can be crowded. For convenience, consider hiring a private driver or renting a car.</p>

<h3>Cultural Etiquette</h3>
<p>When visiting temples, dress modestly and remove your shoes. Always ask permission before taking photos of people. Learn a few basic Sinhala phrases - locals appreciate the effort!</p>

<h3>Health and Safety</h3>
<p>Drink bottled water and be cautious with street food initially. Pack mosquito repellent and consider malaria prophylaxis for certain areas. Travel insurance is highly recommended.</p>

<h3>Currency and Payments</h3>
<p>The local currency is the Sri Lankan Rupee (LKR). While major hotels and restaurants accept credit cards, cash is preferred in smaller establishments. ATMs are widely available in cities.</p>',
                'featured_image' => 'slider/sigiriya_rock.jpg',
                'tags' => ['travel tips', 'sri lanka', 'first time', 'planning', 'culture'],
                'meta_title' => 'Essential Travel Tips for First-Time Visitors to Sri Lanka',
                'meta_description' => 'Complete guide with essential travel tips for first-time visitors to Sri Lanka. Learn about best time to visit, transportation, culture, and more.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
                'views_count' => 1250,
            ],
            [
                'blog_category_id' => $culturalCategory->id,
                'title' => 'Exploring the Ancient City of Anuradhapura',
                'slug' => 'exploring-ancient-city-anuradhapura',
                'excerpt' => 'Discover the ancient capital of Sri Lanka, home to magnificent ruins, sacred Bodhi trees, and centuries of Buddhist heritage.',
                'content' => '<p>Anuradhapura, the first ancient capital of Sri Lanka, is a UNESCO World Heritage Site that showcases the island\'s rich Buddhist heritage and architectural marvels dating back over 2,000 years.</p>

<h3>Historical Significance</h3>
<p>Founded in the 4th century BC, Anuradhapura served as the capital of Sri Lanka for over 1,300 years. It was a major center of Buddhist learning and culture, attracting pilgrims and scholars from across Asia.</p>

<h3>Must-Visit Sites</h3>
<p><strong>Sacred Bodhi Tree:</strong> The oldest historically authenticated tree in the world, grown from a cutting of the original Bodhi tree under which Buddha attained enlightenment.</p>

<p><strong>Ruwanwelisaya:</strong> A magnificent white stupa built by King Dutugemunu in the 2nd century BC, considered one of the most sacred Buddhist sites.</p>

<p><strong>Jetavanaramaya:</strong> Once the third tallest structure in the ancient world, this massive stupa demonstrates the engineering prowess of ancient Sri Lankans.</p>

<h3>Best Time to Visit</h3>
<p>Visit early morning or late afternoon to avoid the midday heat. The site is vast, so plan for a full day to explore properly.</p>

<h3>Cultural Respect</h3>
<p>Dress modestly, remove shoes when entering sacred areas, and maintain silence in religious sites. Photography is allowed but be respectful of worshippers.</p>',
                'featured_image' => 'slider/thooth_relic.jpg',
                'tags' => ['anuradhapura', 'ancient city', 'buddhist heritage', 'unesco', 'history'],
                'meta_title' => 'Exploring the Ancient City of Anuradhapura - UNESCO World Heritage Site',
                'meta_description' => 'Complete guide to exploring Anuradhapura, Sri Lanka\'s ancient capital and UNESCO World Heritage Site with Buddhist temples and ruins.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(3),
                'views_count' => 890,
            ],
            [
                'blog_category_id' => $wildlifeCategory->id,
                'title' => 'Whale Watching in Mirissa: A Complete Guide',
                'slug' => 'whale-watching-mirissa-complete-guide',
                'excerpt' => 'Experience the thrill of spotting blue whales and dolphins in their natural habitat off the coast of Mirissa, Sri Lanka.',
                'content' => '<p>Mirissa, a charming coastal town in southern Sri Lanka, has become one of the world\'s premier destinations for whale watching, offering incredible opportunities to see blue whales, sperm whales, and various dolphin species.</p>

<h3>Best Time for Whale Watching</h3>
<p>The whale watching season in Mirissa runs from November to April, with peak sightings from December to March. During this period, whales migrate close to the Sri Lankan coast to feed and breed.</p>

<h3>What You Can See</h3>
<p><strong>Blue Whales:</strong> The largest animals on Earth, reaching up to 30 meters in length. Mirissa offers one of the best chances globally to see these magnificent creatures.</p>

<p><strong>Sperm Whales:</strong> Often spotted in deeper waters, these whales are known for their distinctive square heads and deep diving abilities.</p>

<p><strong>Dolphins:</strong> Spinner dolphins, bottlenose dolphins, and common dolphins frequently accompany whale watching boats, providing additional entertainment.</p>

<h3>Choosing a Tour</h3>
<p>Select reputable operators with experienced captains and proper safety equipment. Smaller boats (6-12 passengers) often provide better viewing experiences than larger vessels.</p>

<h3>What to Bring</h3>
<p>Pack sunscreen, a hat, sunglasses, and a light jacket. Seasickness medication is recommended for those prone to motion sickness. Don\'t forget your camera with a good zoom lens!</p>

<h3>Responsible Whale Watching</h3>
<p>Choose operators that follow responsible whale watching guidelines, maintaining appropriate distances and avoiding disturbing the animals\' natural behavior.</p>',
                'featured_image' => 'slider/whale_watiching.jpg',
                'tags' => ['whale watching', 'mirissa', 'blue whales', 'wildlife', 'ocean'],
                'meta_title' => 'Whale Watching in Mirissa: Complete Guide to Blue Whale Sightings',
                'meta_description' => 'Complete guide to whale watching in Mirissa, Sri Lanka. Learn about blue whales, best time to visit, tour selection, and responsible whale watching.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(7),
                'views_count' => 2100,
            ],
            [
                'blog_category_id' => $adventureCategory->id,
                'title' => 'Hiking Ella Rock: A Breathtaking Adventure',
                'slug' => 'hiking-ella-rock-breathtaking-adventure',
                'excerpt' => 'Embark on an unforgettable hiking adventure to Ella Rock, offering panoramic views of tea plantations and misty mountains.',
                'content' => '<p>Ella Rock stands as one of Sri Lanka\'s most rewarding hiking destinations, offering spectacular 360-degree views of the hill country\'s tea plantations, misty mountains, and rolling valleys.</p>

<h3>Trail Overview</h3>
<p>The hike to Ella Rock takes approximately 3-4 hours round trip, covering about 8 kilometers. The trail difficulty is moderate, suitable for most fitness levels with some challenging sections.</p>

<h3>Getting Started</h3>
<p>The trail begins near Ella Railway Station. Follow the railway tracks for about 1.5 kilometers before turning right onto a footpath that leads through tea plantations and local villages.</p>

<h3>What to Expect</h3>
<p><strong>Tea Plantations:</strong> Walk through lush green tea estates where you can observe tea pickers at work and learn about the tea-making process.</p>

<p><strong>Local Villages:</strong> Pass through charming hill country villages where friendly locals often offer directions and refreshments.</p>

<p><strong>Panoramic Views:</strong> The summit offers breathtaking views of Little Adam\'s Peak, Ella Gap, and the surrounding mountain ranges.</p>

<h3>Best Time to Hike</h3>
<p>Start early morning (6-7 AM) to avoid the midday heat and crowds. The morning light also provides the best photography opportunities.</p>

<h3>Essential Gear</h3>
<p>Wear comfortable hiking shoes with good grip, bring plenty of water, snacks, sunscreen, and a light jacket. A walking stick can be helpful for the steeper sections.</p>

<h3>Safety Tips</h3>
<p>Hire a local guide if you\'re unfamiliar with the area. The trail can be confusing in places, and guides provide valuable insights about the local culture and environment.</p>',
                'featured_image' => 'slider/ella_city_tour.jpg',
                'tags' => ['hiking', 'ella rock', 'tea plantations', 'adventure', 'mountains'],
                'meta_title' => 'Hiking Ella Rock: Complete Guide to Sri Lanka\'s Scenic Mountain Trail',
                'meta_description' => 'Complete guide to hiking Ella Rock in Sri Lanka. Learn about the trail, best time to visit, what to expect, and essential hiking tips.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(10),
                'views_count' => 1680,
            ],
            [
                'blog_category_id' => $foodCategory->id,
                'title' => 'Sri Lankan Cuisine: A Culinary Journey Through Spices and Flavors',
                'slug' => 'sri-lankan-cuisine-culinary-journey-spices-flavors',
                'excerpt' => 'Discover the rich and diverse flavors of Sri Lankan cuisine, from aromatic curries to traditional sweets and street food delights.',
                'content' => '<p>Sri Lankan cuisine is a vibrant fusion of flavors influenced by Indian, Arab, Portuguese, Dutch, and British culinary traditions. Known for its bold spices, fresh ingredients, and diverse cooking methods, Sri Lankan food offers an unforgettable gastronomic experience.</p>

<h3>Signature Dishes</h3>
<p><strong>Rice and Curry:</strong> The national dish featuring steamed rice served with an array of curries, sambols, and pickles. Each meal typically includes 3-5 different curries.</p>

<p><strong>Hoppers (Appa):</strong> Bowl-shaped pancakes made from fermented rice flour and coconut milk, often served with egg or sweet fillings.</p>

<p><strong>String Hoppers (Idiyappam):</strong> Delicate rice noodle nests, perfect for soaking up curry sauces.</p>

<p><strong>Kottu Roti:</strong> A popular street food made by chopping flatbread with vegetables, meat, and spices on a hot griddle.</p>

<h3>Essential Spices</h3>
<p>Sri Lankan cuisine relies heavily on spices like cinnamon, cardamom, cloves, nutmeg, curry leaves, and the famous Ceylon cinnamon. The spice blend known as "curry powder" varies by region and family recipes.</p>

<h3>Regional Variations</h3>
<p><strong>Coastal Areas:</strong> Feature more seafood dishes, coconut-based curries, and tropical fruits.</p>

<p><strong>Hill Country:</strong> Known for vegetable curries, dairy products, and European-influenced dishes.</p>

<p><strong>Northern Cuisine:</strong> Influenced by South Indian flavors with more vegetarian options.</p>

<h3>Street Food Delights</h3>
<p>Explore local markets and street vendors for authentic experiences. Try fish ambul thiyal (sour fish curry), lamprais (Dutch-influenced rice packet), and various sweets like kokis and aasmi.</p>

<h3>Dining Etiquette</h3>
<p>Traditionally, Sri Lankans eat with their right hand, mixing rice with curries. In restaurants, utensils are provided. Always try a bit of everything - it\'s considered polite!</p>',
                'featured_image' => 'slider/arugam_bay.jpg',
                'tags' => ['sri lankan cuisine', 'spices', 'curry', 'street food', 'traditional food'],
                'meta_title' => 'Sri Lankan Cuisine: Complete Guide to Traditional Food and Flavors',
                'meta_description' => 'Complete guide to Sri Lankan cuisine including signature dishes, spices, regional variations, street food, and dining etiquette.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(12),
                'views_count' => 1450,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['slug' => $blog['slug']],
                $blog
            );
        }
    }
}
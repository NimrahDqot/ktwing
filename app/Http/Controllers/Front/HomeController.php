<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\PageHomeItem;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyLocation;
use App\Models\HomeAdvertisement;
use App\Models\Testimonial;
use App\Models\PageDreamProperty;
use App\Models\PageBlogItem;
use App\Models\Blog;
use App\Models\PageOtherItem;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $adv_home_data = HomeAdvertisement::where('id',1)->first();
        $page_other_item = PageOtherItem::where('id',1)->first();

    	$page_home_items = PageHomeItem::where('id',1)->first();
    	$page_dream_property = PageDreamProperty::where('id',1)->first();
    	$page_blog = PageBlogItem::where('id',1)->first();

        $testimonials = Testimonial::get();
        $testimonials->map(function($testimonial){
            $testimonial->all_over_rating = (($testimonial->service_rating) + ($testimonial->schedule_rating) + ($testimonial->cost_rating) + ($testimonial->willing_to_refer_rating))/4;
            $testimonial->all_over_rating =  number_format($testimonial->all_over_rating,1);
            return $testimonial;
        });
        $property_categories = PropertyCategory::orderBy('property_category_name','asc')->get();
        $property_locations = PropertyLocation::orderBy('property_location_name','asc')->get();

        $orderwise_property_categories = DB::select('SELECT *
                        FROM property_categories as r1
                        LEFT JOIN (SELECT property_category_id, count(*) as total
                            FROM properties as l
                            JOIN property_categories as lc
                            ON l.property_category_id = lc.id
                            GROUP BY property_category_id
                            ORDER BY total DESC) as r2
                        ON r1.id = r2.property_category_id
                        ORDER BY r2.total DESC');
        $orderwise_property_categories = DB::select('SELECT r1.*, r2.total
        FROM property_categories as r1
        LEFT JOIN (
            SELECT property_category_id, count(*) as total
            FROM properties as l
            JOIN property_categories as lc ON l.property_category_id = lc.id
            GROUP BY property_category_id
        ) as r2 ON r1.id = r2.property_category_id
        ORDER BY r1.property_order ASC, r2.total DESC');

        $orderwise_property_locations = DB::select('SELECT *
                        FROM property_locations as r1
                        LEFT JOIN (SELECT property_location_id, count(*) as total
                            FROM properties as l
                            JOIN property_locations as ll
                            ON l.property_location_id = ll.id
                            GROUP BY property_location_id
                            ORDER BY total DESC) as r2
                        ON r1.id = r2.property_location_id
                        ORDER BY r2.total DESC');

        $properties = Property::with('rPropertyCategory','rPropertyLocation')
            ->orderBy('property_name','asc')
            ->where('property_status','Active')
            ->where('is_featured','Yes')
            ->where('is_approved','1')
            ->get();
            $blogs = Blog::orderby('id', 'desc')->get();

        return view('front.index', compact('page_other_item','adv_home_data','page_home_items','orderwise_property_categories','orderwise_property_locations','properties','property_categories','property_locations','testimonials','page_dream_property','page_blog','blogs'));
    }
}

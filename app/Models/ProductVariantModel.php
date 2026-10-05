<?php

namespace App\Models;

use App\Models\FunctionModel;
use App\Traits\CommonTraits;

class ProductVariantModel extends FunctionModel
{
    use CommonTraits;
    protected $table            = 'product_variant';
    protected $primaryKey       = 'variant_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'variant_id',
        'unit_id',
        'variant_name',
        'product_variant_seo_title',
        'product_id',
        'size_id',
        'is_active',
        'variant_sku_code',
        'color_id',
        'variant_alt_text1',
        'variant_alt_text2',
        'variant_alt_text3',
        'variant_alt_text4',
        'variant_alt_text5',
        'variant_alt_text6',
        'minimum_stock',
        'variant_weight',
        'purchase_rate',
        'mrp',
        'discount_per',
        'discount_amt',
        'gst_per',
        'gst_amt',
        'selling_price',
        'delivery_charge',
        'cost_price',
        'profit_per',
        'profit_amt',
        'variant_description',
        'variant_seo_keyword',
        'variant_seo_description',
        'variant_image1',
        'variant_image2',
        'variant_image3',
        'variant_image4',
        'variant_image5',
        'variant_image6',
        'selected_update',
        'cod_charges'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $messageAlias = 'Product_variant';
    // Validation
    protected $validationRules = [
        'variant_id' => 'permit_empty',
        'variant_name' => 'required|max_length[255]',
        'unit_id' => 'required|integer|is_not_unique[unit.unit_id]',
        'color_id' => 'permit_empty|integer|is_not_unique[color.color_id]',
        'product_id' => 'required|integer|is_not_unique[product.product_id]',
        'size_id' => 'permit_empty',
        'variant_sku_code' => 'required|max_length[255]|is_unique[product_variant.variant_sku_code,variant_id,{variant_id}]',
        'minimum_stock' => 'required',
        'variant_weight' => 'required',
        'purchase_rate' => 'permit_empty',
        'mrp' => 'required',
        'discount_per' => 'permit_empty',
        'discount_amt' => 'permit_empty',
        'gst_per' => 'required',
        'gst_amt' => 'permit_empty',
        'selling_price' => 'required',
        'delivery_charge' => 'permit_empty',
        'cost_price' => 'permit_empty',
        'profit_per' => 'permit_empty',
        'profit_amt' => 'permit_empty',
        'variant_description' => 'permit_empty',
        'variant_seo_description' => 'permit_empty|max_length[170]',
        'variant_seo_keyword' => 'permit_empty',
        'product_variant_seo_title' => 'permit_empty|max_length[60]',
        'variant_image1' => 'permit_empty',
        'variant_alt_text1' => 'permit_empty',
        'variant_image2' => 'permit_empty',
        'variant_alt_text2' => 'permit_empty',
        'variant_image3' => 'permit_empty',
        'variant_alt_text3' => 'permit_empty',
        'variant_image4' => 'permit_empty',
        'variant_alt_text4' => 'permit_empty',
        'variant_image5' => 'permit_empty',
        'variant_alt_text5' => 'permit_empty',
        'variant_image6' => 'permit_empty',
        'variant_alt_text6' => 'permit_empty',
        'is_active' => 'permit_empty',
        'cod_charges' => 'permit_empty',
    ];

    protected $booleanFields = ["is_active"];
    protected $validationMessages = [
        'variant_name' => [
            'required' => 'Varitant name is required.',
            'max_length' => 'Max 255 characters.',
        ],
        'variant_sku_code' => [
            'required' => 'Varitant Code name is required.',
            'is_unique' => 'Varitant Code must be Unique.',
        ],
        'variant_seo_description' => [
            'max_length' => 'Max 120 characters.'
        ],
        'variant_seo_keyword' => [
            'max_length' => 'Max 120 characters.'
        ],
        'product_variant_seo_title' => [
            'max_length' => 'Max 120 characters.'
        ],
        'color_id' => [
            'required' => 'Color ID name is required.'
        ],
        'mrp' => [
            'required' => 'M.R.P is required.'
        ],
        'gst_per' => [
            'required' => 'GST is required.',
        ],
        'product_id' => [
            'required' => 'Product Id is required.'
        ],
        'unit_id' => [
            'required' => 'Unit Id is required.'
        ],
        'variant_image1' => [
            'required' => 'Image is required.'
        ],
        'selling_price' => [
            'required' => 'Please Enter Selling Price.'
        ],
        'variant_weight' => [
            'required' => 'Please Enter Variant Weight.'
        ],

    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['calculate_variant', 'updateBooleanFields'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['calculate_variant', 'updateBooleanFields'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function __construct()
    {
        parent::__construct();
        $this->addParentJoin('product_id', $this->getProductModel(), 'left', ['product_name']);
        $this->addParentJoin('color_id', $this->getColorModel(), 'left', ['color_name']);
        $this->addParentJoin('unit_id', $this->getUnitModel(), 'left', ['unit_name']);
        $this->addParentJoin('size_id', $this->getSizeModel(), 'left', ['size_name']);
    }


    public function calculate_variant($data)
    {

        // Purchase Rate (W/O GST)
        if (isset($data['data']['selected_update'])  && $data['data']['selected_update']) {
            unset($data['data']['selected_update']);
        } else {
            $purchase_rate = isset($data['data']['purchase_rate']) ? round((float) $data['data']['purchase_rate'], 2) : 0.00;

            // M.R.P Inclusive GST
            $mrp = isset($data['data']['mrp']) ? round((float) $data['data']['mrp'], 2) : 0.00;

            // Discount Percentage in Num
            $dis_per = isset($data['data']['discount_per']) ? round((float) $data['data']['discount_per'], 2) : 0.00;

            // Discount Amount
            $dis_amt = round(($mrp * $dis_per) / 100, 2);

            // Deal Of The day Discount %
            $deal_dis_per = isset($data['data']['discount']) ? round((float) $data['data']['discount'], 2) : 0.00;
            // Deal Of The day Discount Amount
            $deal_dis_amt = round((($mrp - $dis_amt) * $deal_dis_per) / 100, 2);

            // Selling Price After Less Discount GST Included
            $selling_price = round($mrp - ($dis_amt + $deal_dis_amt), 0);

            // GST Percentage in Num
            $gst_per = isset($data['data']['gst_per']) ? round((float) $data['data']['gst_per'], 2) : 0.00;

            // Taxable Amount (Selling Price excluding GST)
            $taxable_amt = ($gst_per != 0) ? round($selling_price / (1 + ($gst_per / 100)), 2) : $selling_price;

            // GST Amount
            $gst_amt = round($selling_price - $taxable_amt, 2);

            // Profit Percentage
            $profit_per = ($purchase_rate != 0) ? round((($taxable_amt - $purchase_rate) / $purchase_rate) * 100, 2) : 0.00;

            // Profit Amount (W/O GST)
            $profit_amt = ($profit_per != 0) ? round($taxable_amt - $purchase_rate, 2) : 0.00;


            // Assigning the calculated values back to the data array
            $data['data']['discount_amt'] = $dis_amt;
            $data['data']['discount_deal_amt'] = $deal_dis_amt;
            $data['data']['selling_price'] = $selling_price;
            $data['data']['cost_price'] = $taxable_amt;
            $data['data']['gst_amt'] = $gst_amt;
            $data['data']['profit_per'] = $profit_per;
            $data['data']['profit_amt'] = $profit_amt;
        }

        // Return calculated data
        return $data;
    }
}

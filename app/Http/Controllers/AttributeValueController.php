<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeValueController extends Controller
{
    public function index()
    {
        $values = AttributeValue::with('attribute')->get();
        return view('admin.attribute-values.index', compact('values'));
    }

    public function create()
    {
        return view('admin.attribute-values.create', [
            'attributes' => Attribute::all()
        ]);
    }

    public function store(Request $request)
    {
        AttributeValue::create($request->all());
        return redirect()->route('attribute-values.index');
    }

  public function edit(AttributeValue $attribute_value)
{
    $attributes = Attribute::all();
    return view('admin.attribute-values.edit', compact('attribute_value', 'attributes'));
}

    
    public function update(Request $request, AttributeValue $attribute_value)
{
    $attribute_value->update($request->all());
    return redirect()->route('attribute-values.index')->with('success', 'Value updated successfully.');
}


    
    public function destroy(AttributeValue $value)
    {
        $value->delete();
        return redirect()->route('attribute-values.index')->with('success', 'Attribute Value deleted!');
    }
}

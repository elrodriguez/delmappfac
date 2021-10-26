@php
//dd($document);
//foreach ($document->items as $row){
//    dd(json_decode($row->item, true));
//}
    $invoice = $document->invoice->first();
    $establishment = json_decode($document->establishment);
    $customer = json_decode($document->customer);

    $district = \Illuminate\Support\Facades\DB::table('districts')->where('id',$establishment->district_id)->first();
    $province = \Illuminate\Support\Facades\DB::table('provinces')->where('id',$establishment->province_id)->first();
    $department = \Illuminate\Support\Facades\DB::table('departments')->where('id',$establishment->department_id)->first();

    $identity_document_type = \App\Models\Catalogue\IdentityDocumentType::find($customer->identity_document_type_id);
    $customer_district = \Illuminate\Support\Facades\DB::table('districts')->where('id',$customer->district_id)->first();
    $customer_province = \Illuminate\Support\Facades\DB::table('provinces')->where('id',$customer->province_id)->first();
    $customer_department = \Illuminate\Support\Facades\DB::table('departments')->where('id',$customer->department_id)->first();
    $amount_plastic_bag_taxes = \Illuminate\Support\Facades\DB::table('parameters')->where('id_parameter','PRT006ICP')->value('value_default');
@endphp
{!! '<?xml version="1.0" encoding="utf-8" standalone="no"?>' !!}
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"
         xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
         xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
         xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
         xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
    <cbc:CustomizationID>2.0</cbc:CustomizationID>
    <cbc:ID>{{ $document->series }}-{{ $document->number }}</cbc:ID>
    <cbc:IssueDate>{{ $document->date_of_issue }}</cbc:IssueDate>
    <cbc:IssueTime>{{ $document->time_of_issue }}</cbc:IssueTime>
    @if($invoice->date_of_due)
    <cbc:DueDate>{{ $invoice->date_of_due }}</cbc:DueDate>
    @endif
    <cbc:InvoiceTypeCode listID="{{ $invoice->operation_type_id }}">{{ $document->document_type_id }}</cbc:InvoiceTypeCode>
    @php
        $legend = json_decode($document->legends);
    @endphp
    {{-- @foreach($document->legends as $leg) --}}
    <cbc:Note languageLocaleID="{{ $legend->code }}"><![CDATA[{{ $legend->value }}]]></cbc:Note>
    {{-- @endforeach --}}
    <cbc:DocumentCurrencyCode>{{ $document->currency_type_id }}</cbc:DocumentCurrencyCode>
    @if($document->purchase_order)
    <cac:OrderReference>
        <cbc:ID>{{ $document->purchase_order }}</cbc:ID>
    </cac:OrderReference>
    @endif
    @if($document->guides)
    @foreach($document->guides as $guide)
    <cac:DespatchDocumentReference>
        <cbc:ID>{{ $guide->number }}</cbc:ID>
        <cbc:DocumentTypeCode>{{ $guide->document_type_id }}</cbc:DocumentTypeCode>
    </cac:DespatchDocumentReference>
    @endforeach
    @endif
    @if($document->related)
    @foreach($document->related as $rel)
    <cac:AdditionalDocumentReference>
        <cbc:ID>{{ $rel->number }}</cbc:ID>
        <cbc:DocumentTypeCode>{{ $rel->document_type_id }}</cbc:DocumentTypeCode>
    </cac:AdditionalDocumentReference>
    @endforeach
    @endif
    @if($document->prepayments)
    @foreach($document->prepayments as $prepayment)
    <cac:AdditionalDocumentReference>
        <cbc:ID>{{ $prepayment->number }}</cbc:ID>
        <cbc:DocumentTypeCode>{{ $prepayment->document_type_id }}</cbc:DocumentTypeCode>
        <cbc:DocumentStatusCode>{{ $loop->iteration }}</cbc:DocumentStatusCode>
        <cac:IssuerParty>
            <cac:PartyIdentification>
                <cbc:ID schemeID="6">{{ $company->number }}</cbc:ID>
            </cac:PartyIdentification>
        </cac:IssuerParty>
    </cac:AdditionalDocumentReference>
    @endforeach
    @endif
    <cac:Signature>
        <cbc:ID>{{ config('configuration.signature_uri') }}</cbc:ID>
        <cbc:Note>{{ config('configuration.signature_note') }}</cbc:Note>
        <cac:SignatoryParty>
            <cac:PartyIdentification>
                <cbc:ID>{{ $company->number }}</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[{{ $company->tradename }}]]></cbc:Name>
            </cac:PartyName>
        </cac:SignatoryParty>
        <cac:DigitalSignatureAttachment>
            <cac:ExternalReference>
                <cbc:URI>#{{ config('configuration.signature_uri') }}</cbc:URI>
            </cac:ExternalReference>
        </cac:DigitalSignatureAttachment>
    </cac:Signature>
    <cac:AccountingSupplierParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID="6">{{ $company->number }}</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[{{ $company->tradename }}]]></cbc:Name>
            </cac:PartyName>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[{{ $company->name }}]]></cbc:RegistrationName>
                <cac:RegistrationAddress>
                    <cbc:ID>{{ $establishment->district_id }}</cbc:ID>
                    <cbc:AddressTypeCode>{{ str_pad($establishment->id, 4, "0", STR_PAD_LEFT) }}</cbc:AddressTypeCode>
                    @if($establishment->urbanization)
                    <cbc:CitySubdivisionName>{{ $establishment->urbanization }}</cbc:CitySubdivisionName>
                    @endif
                    <cbc:CityName>{{ $province->description }}</cbc:CityName>
                    <cbc:CountrySubentity>{{ $department->description }}</cbc:CountrySubentity>
                    <cbc:District>{{ $district->description }}</cbc:District>
                    @if($establishment->address && $establishment->address !== '-')
                    <cac:AddressLine>
                        <cbc:Line><![CDATA[{{ $establishment->address }}]]></cbc:Line>
                    </cac:AddressLine>
                    @endif
                    <cac:Country>
                        <cbc:IdentificationCode>{{ $establishment->country_id }}</cbc:IdentificationCode>
                    </cac:Country>
                </cac:RegistrationAddress>
            </cac:PartyLegalEntity>
            @if($establishment->email || $establishment->phone)
            <cac:Contact>
                @if($establishment->phone)
                <cbc:Telephone>{{ $establishment->phone }}</cbc:Telephone>
                @endif
                @if($establishment->email)
                <cbc:ElectronicMail>{{ $establishment->email }}</cbc:ElectronicMail>
                @endif
            </cac:Contact>
            @endif
        </cac:Party>
    </cac:AccountingSupplierParty>
    <cac:AccountingCustomerParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID="{{ $customer->identity_document_type_id }}">{{ $customer->number }}</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[{{ $customer->name }}]]></cbc:RegistrationName>
                @if($customer->address && $customer->address !== '-')
                <cac:RegistrationAddress>
                    @if($customer->district_id)
                    <cbc:ID>{{ $customer->district_id }}</cbc:ID>
                    @endif
                    <cac:AddressLine>
                        <cbc:Line><![CDATA[{{ $customer->address }}]]></cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode>{{ $customer->country_id }}</cbc:IdentificationCode>
                    </cac:Country>
                </cac:RegistrationAddress>
                @endif
            </cac:PartyLegalEntity>
            @if($customer->email || $customer->telephone)
            <cac:Contact>
                @if($customer->telephone)
                <cbc:Telephone>{{ $customer->telephone }}</cbc:Telephone>
                @endif
                @if($customer->email)
                <cbc:ElectronicMail>{{ $customer->email }}</cbc:ElectronicMail>
                @endif
            </cac:Contact>
            @endif
        </cac:Party>
    </cac:AccountingCustomerParty>
    @if($document->detraction)
        @php($detraction = $document->detraction)
        <cac:PaymentMeans>
            <cbc:PaymentMeansCode>{{ $detraction->payment_method_id }}</cbc:PaymentMeansCode>
            <cac:PayeeFinancialAccount>
                <cbc:ID>{{ $detraction->bank_account }}</cbc:ID>
            </cac:PayeeFinancialAccount>
        </cac:PaymentMeans>
        <cac:PaymentTerms>
            <cbc:PaymentMeansID>{{ $detraction->detraction_type_id }}</cbc:PaymentMeansID>
            <cbc:PaymentPercent>{{ $detraction->percentage }}</cbc:PaymentPercent>
            <cbc:Amount currencyID="PEN">{{ $detraction->amount }}</cbc:Amount>
        </cac:PaymentTerms>
    @endif
    @if($document->perception)
    @php($perception = $document->perception)
    <cac:PaymentTerms>
        <cbc:ID>Percepcion</cbc:ID>
        <cbc:Amount currencyID="PEN">{{ $perception->amount }}</cbc:Amount>
    </cac:PaymentTerms>
    @endif
    @if($document->prepayments)
    @foreach($document->prepayments as $prepayment)
    <cac:PrepaidPayment>
        <cbc:ID>{{ $loop->iteration }}</cbc:ID>
        <cbc:PaidAmount currencyID="{{ $document->currency_type_id }}">{{ $prepayment->amount }}</cbc:PaidAmount>
    </cac:PrepaidPayment>
    @endforeach
    @endif
    @if($document->charges)
    @foreach($document->charges as $charge)
    <cac:AllowanceCharge>
        <cbc:ChargeIndicator>true</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReasonCode>{{ $charge->charge_type_id }}</cbc:AllowanceChargeReasonCode>
        <cbc:MultiplierFactorNumeric>{{ $charge->factor }}</cbc:MultiplierFactorNumeric>
        <cbc:Amount currencyID="{{ $document->currency_type_id }}">{{ $charge->amount }}</cbc:Amount>
        <cbc:BaseAmount currencyID="{{ $document->currency_type_id }}">{{ $charge->base }}</cbc:BaseAmount>
    </cac:AllowanceCharge>
    @endforeach
    @endif
    @if($document->discounts)
    @foreach($document->discounts as $discount)
    <cac:AllowanceCharge>
        <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReasonCode>{{ $discount->discount_type_id }}</cbc:AllowanceChargeReasonCode>
        <cbc:MultiplierFactorNumeric>{{ $discount->factor }}</cbc:MultiplierFactorNumeric>
        <cbc:Amount currencyID="{{ $document->currency_type_id }}">{{ $discount->amount }}</cbc:Amount>
        <cbc:BaseAmount currencyID="{{ $document->currency_type_id }}">{{ $discount->base }}</cbc:BaseAmount>
    </cac:AllowanceCharge>
    @endforeach
    @endif
    @if($document->perception)
    @php($perception = $document->perception)
    <cac:AllowanceCharge>
        <cbc:ChargeIndicator>true</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReasonCode>{{ $perception->code }}</cbc:AllowanceChargeReasonCode>
        <cbc:MultiplierFactorNumeric>{{ $perception->percentage }}</cbc:MultiplierFactorNumeric>
        <cbc:Amount currencyID="PEN">{{ $perception->amount }}</cbc:Amount>
        <cbc:BaseAmount currencyID="PEN">{{ $perception->base }}</cbc:BaseAmount>
    </cac:AllowanceCharge>
    @endif
    <cac:TaxTotal>
        <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_igv }}</cbc:TaxAmount>
        @if($document->total_isc > 0)
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_base_isc }}</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_isc }}</cbc:TaxAmount>
            <cac:TaxCategory>
                <cac:TaxScheme>
                    <cbc:ID>2000</cbc:ID>
                    <cbc:Name>ISC</cbc:Name>
                    <cbc:TaxTypeCode>EXC</cbc:TaxTypeCode>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
        @endif
        @if($document->total_taxed > 0)
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_taxed }}</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_igv }}</cbc:TaxAmount>
            <cac:TaxCategory>
                <cac:TaxScheme>
                    <cbc:ID>1000</cbc:ID>
                    <cbc:Name>IGV</cbc:Name>
                    <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
        @endif
        @if($document->total_unaffected > 0)
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_unaffected }}</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">0</cbc:TaxAmount>
            <cac:TaxCategory>
                <cac:TaxScheme>
                    <cbc:ID>9998</cbc:ID>
                    <cbc:Name>INA</cbc:Name>
                    <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
        @endif
        @if($document->total_exonerated > 0)
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_exonerated }}</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">0</cbc:TaxAmount>
            <cac:TaxCategory>
                <cac:TaxScheme>
                    <cbc:ID>9997</cbc:ID>
                    <cbc:Name>EXO</cbc:Name>
                    <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
        @endif
        @if($document->total_free > 0)
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_free }}</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_igv }}</cbc:TaxAmount>
            <cac:TaxCategory>
                <cac:TaxScheme>
                    <cbc:ID>9996</cbc:ID>
                    <cbc:Name>GRA</cbc:Name>
                    <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
        @endif
        @if($document->total_exportation > 0)
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_exportation }}</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">0</cbc:TaxAmount>
            <cac:TaxCategory>
                <cac:TaxScheme>
                    <cbc:ID>9995</cbc:ID>
                    <cbc:Name>EXP</cbc:Name>
                    <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
        @endif
        @if($document->total_other_taxes > 0)
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_other_taxes }}</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_base_other_taxes }}</cbc:TaxAmount>
            <cac:TaxCategory>
                <cac:TaxScheme>
                    <cbc:ID>9999</cbc:ID>
                    <cbc:Name>OTROS</cbc:Name>
                    <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
        @endif
        @if($document->total_plastic_bag_taxes > 0)
        <cac:TaxSubtotal>
            <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_plastic_bag_taxes }}</cbc:TaxAmount>
            <cac:TaxCategory>
                <cac:TaxScheme>
                    <cbc:ID>7152</cbc:ID>
                    <cbc:Name>ICBPER</cbc:Name>
                    <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
        @endif
    </cac:TaxTotal>
    <cac:LegalMonetaryTotal>
        <cbc:LineExtensionAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_value }}</cbc:LineExtensionAmount>
        <cbc:TaxInclusiveAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total }}</cbc:TaxInclusiveAmount>
        @if($document->total_discount > 0)
        <cbc:AllowanceTotalAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_discount }}</cbc:AllowanceTotalAmount>
        @endif
        @if($document->total_charges > 0)
        <cbc:ChargeTotalAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_charges }}</cbc:ChargeTotalAmount>
        @endif
        @if($document->total_prepayment > 0)
        <cbc:PrepaidAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total_prepayment }}</cbc:PrepaidAmount>
        @endif
        <cbc:PayableAmount currencyID="{{ $document->currency_type_id }}">{{ $document->total }}</cbc:PayableAmount>
    </cac:LegalMonetaryTotal>
    @foreach($document->items as $row)
    <cac:InvoiceLine>
        <cbc:ID>{{ $loop->iteration }}</cbc:ID>
        <cbc:InvoicedQuantity unitCode="{{ json_decode($row->item, true)['unit_type_id'] }}" unitCodeListID="UN/ECE rec 20">{{ $row->quantity }}</cbc:InvoicedQuantity>
        <cbc:LineExtensionAmount currencyID="{{ $document->currency_type_id }}">{{ $row->total_value }}</cbc:LineExtensionAmount>
        <cac:PricingReference>
            <cac:AlternativeConditionPrice>
                <cbc:PriceAmount currencyID="{{ $document->currency_type_id }}">{{ $row->unit_price }}</cbc:PriceAmount>
                <cbc:PriceTypeCode>{{ $row->price_type_id }}</cbc:PriceTypeCode>
            </cac:AlternativeConditionPrice>
        </cac:PricingReference>
        @if($row->charges)
        @foreach($row->charges as $charge)
        <cac:AllowanceCharge>
            <cbc:ChargeIndicator>true</cbc:ChargeIndicator>
            <cbc:AllowanceChargeReasonCode>{{ $charge->charge_type_id }}</cbc:AllowanceChargeReasonCode>
            <cbc:MultiplierFactorNumeric>{{ $charge->factor }}</cbc:MultiplierFactorNumeric>
            <cbc:Amount currencyID="{{ $document->currency_type_id }}">{{ $charge->amount }}</cbc:Amount>
            <cbc:BaseAmount currencyID="{{ $document->currency_type_id }}">{{ $charge->base }}</cbc:BaseAmount>
        </cac:AllowanceCharge>
        @endforeach
        @endif
        @if($row->discounts)
        @foreach($row->discounts as $discount)
        <cac:AllowanceCharge>
            <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
            <cbc:AllowanceChargeReasonCode>{{ $discount->discount_type_id }}</cbc:AllowanceChargeReasonCode>
            <cbc:MultiplierFactorNumeric>{{ $discount->factor }}</cbc:MultiplierFactorNumeric>
            <cbc:Amount currencyID="{{ $document->currency_type_id }}">{{ $discount->amount }}</cbc:Amount>
            <cbc:BaseAmount currencyID="{{ $document->currency_type_id }}">{{ $discount->base }}</cbc:BaseAmount>
        </cac:AllowanceCharge>
        @endforeach
        @endif
        <cac:TaxTotal>
            <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $row->total_taxes }}</cbc:TaxAmount>
            @if($row->total_isc > 0)
            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $row->total_base_isc }}</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $row->total_isc }}</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>{{ $row->percentage_isc }}</cbc:Percent>
                    <cbc:TierRange>{{ $row->system_isc_type_id }}</cbc:TierRange>
                    <cac:TaxScheme>
                        <cbc:ID>2000</cbc:ID>
                        <cbc:Name>ISC</cbc:Name>
                        <cbc:TaxTypeCode>EXC</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            @endif
            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $row->total_base_igv }}</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $row->total_igv }}</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>{{ $row->percentage_igv }}</cbc:Percent>
                    <cbc:TaxExemptionReasonCode>{{ $row->affectation_igv_type_id }}</cbc:TaxExemptionReasonCode>
                    @php($affectation = \App\CoreBilling\Templates\FunctionTribute::getByAffectation($row->affectation_igv_type_id))
                    <cac:TaxScheme>
                        <cbc:ID>{{ $affectation['id'] }}</cbc:ID>
                        <cbc:Name>{{ $affectation['name'] }}</cbc:Name>
                        <cbc:TaxTypeCode>{{ $affectation['code'] }}</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            @if($row->total_other_taxes > 0)
            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID="{{ $document->currency_type_id }}">{{ $row->total_base_other_taxes }}</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{ $row->total_other_taxes }}</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>{{ $row->percentage_other_taxes }}</cbc:Percent>
                    <cac:TaxScheme>
                        <cbc:ID>9999</cbc:ID>
                        <cbc:Name>OTROS</cbc:Name>
                        <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            @endif
            @if($row->total_plastic_bag_taxes > 0)
            <cac:TaxSubtotal>
                <cbc:TaxAmount currencyID="{{ $document->currency_type_id }}">{{$row->total_plastic_bag_taxes}}</cbc:TaxAmount>
                <cbc:BaseUnitMeasure unitCode="NIU">{{ round($row->quantity,0) }}</cbc:BaseUnitMeasure>
                <cac:TaxCategory>
                    <cbc:PerUnitAmount currencyID="{{ $document->currency_type_id }}">{{ $amount_plastic_bag_taxes }}</cbc:PerUnitAmount>
                    <cac:TaxScheme>
                        <cbc:ID>7152</cbc:ID>
                        <cbc:Name>ICBPER</cbc:Name>
                        <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            @endif
        </cac:TaxTotal>
        <cac:Item>
            <cbc:Description><![CDATA[{{ json_decode($row->item, true)['description'] }}]]></cbc:Description>
            @if(json_decode($row->item, true)['internal_id'])
            <cac:SellersItemIdentification>
                <cbc:ID>{{ json_decode($row->item, true)['internal_id'] }}</cbc:ID>
            </cac:SellersItemIdentification>
            @endif
            @if(json_decode($row->item, true)['item_code'])
            <cac:CommodityClassification>
                <cbc:ItemClassificationCode>{{ json_decode($row->item, true)['item_code'] }}</cbc:ItemClassificationCode>
            </cac:CommodityClassification>
            @endif
            @if(json_decode($row->item, true)['item_code_gs1'])
            <cac:StandardItemIdentification>
                <cbc:ID>{{ json_decode($row->item, true)['item_code_gs1'] }}</cbc:ID>
            </cac:StandardItemIdentification>
            @endif
            @if($row->attributes)
            @foreach($row->attributes as $attr)
            <cac:AdditionalItemProperty>
                <cbc:Name><![CDATA[{{ $attr->description }}]]></cbc:Name>
                <cbc:NameCode>{{ $attr->attribute_type_id }}</cbc:NameCode>
                @if($attr->value)
                <cbc:Value>{{ $attr->value }}</cbc:Value>
                @endif
                @if($attr->start_date || $attr->end_date || $attr->duration)
                <cac:UsabilityPeriod>
                    @if($attr->start_date)
                    <cbc:StartDate>{{ $attr->start_date }}</cbc:StartDate>
                    @endif
                    @if($attr->end_date)
                    <cbc:EndDate>{{ $attr->end_date }}</cbc:EndDate>
                    @endif
                    @if($attr->duration)
                    <cbc:DurationMeasure unitCode="DAY">{{ $attr->duration }}</cbc:DurationMeasure>
                    @endif
                </cac:UsabilityPeriod>
                @endif
            </cac:AdditionalItemProperty>
            @endforeach
            @endif
        </cac:Item>
        <cac:Price>
            <cbc:PriceAmount currencyID="{{ $document->currency_type_id }}">{{ $row->unit_value }}</cbc:PriceAmount>
        </cac:Price>
    </cac:InvoiceLine>
    @endforeach
</Invoice>

@extends('layouts.frontend')


@section('content')


    <div class="form-group">
        <div class="form-flex">
            <div class="form-column form-column-field">
                <select class="select select-no-search" data-no-search data-placeholder="Select year">
                    <option></option>
                    <option value="1999">1999</option>
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>
            <div class="form-column form-column-text">
                <div class="form-text"></div>
            </div>
        </div>


    </div>


@endsection


{{--@section('scripts')--}}
<script>
    console.log('sel_test.blade.php ::')

    jQuery(document).ready(function () {
        console.log('jQuery(document).ready(function () sel_test.blade.php ::')

        // if ($('.select').length){
        //
        //     $('.select').each(function(){
        //         let nosearch = $(this).attr("data-no-search");
        //         let dropdownClass = "";
        //
        //         if (nosearch != undefined){
        //             dropdownClass = "dropdown-no-search"
        //         }
        //         $(this).select2({
        //             language: "ru",
        //             dropdownCssClass : dropdownClass
        //         });
        //     });
        // }

    });


</script>
{{--@endsection--}}

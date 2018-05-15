
@extends('layouts.app_basic')



@section('content')


    <div class="container-fluid">
        <client-lock-screen :show="true" :modal-content0="true" :modal-content1="true">
            <div slot="modalBody0">
                <client-form-status></client-form-status>
                <lang-select></lang-select>
                <credentials-form></credentials-form>
            </div>

            <div slot="modalBody1">
                <medical-form></medical-form>
                <stress-level-form></stress-level-form>
                <skin-products-form></skin-products-form>
                <medications-form></medications-form>
                <allergies-form></allergies-form>
                <illnesses-form></illnesses-form>
                <surgeries-form></surgeries-form>
                <terms-conditions></terms-conditions>
            </div>
         </client-lock-screen>
    </div>


@endsection
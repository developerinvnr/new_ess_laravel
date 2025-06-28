@include('employee.header')

<body class="mini-sidebar">
   @include('employee.sidebar')
   <div id="loader" style="display:none;">
      <div class="spinner-border text-primary" role="status">
         <span class="sr-only">Loading...</span>
      </div>
   </div>
   <!-- Main Body -->
   <div class="page-wrapper">
      <!-- Header Start -->
      @include('employee.head')
      <!-- Container Start -->
      <div class="page-wrapper">
         <div class="main-content">
            <!-- Page Title Start -->
            <div class="row">
               <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="page-title-wrapper">
                     <div class="breadcrumb-list">
                        <ul>
                           <li class="breadcrumb-link">
                              <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                           </li>
                           <li class="breadcrumb-link active">Assets</li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            @php
            $empId = Auth::user()->EmployeeID;
            $isAccountApprover = false;
            $isHODApprover = false;
            $isITApprover = false;
            @endphp
            <!-- Dashboard Start -->
            <div class="row">
               <!-- Success Message -->
               @if(session('success'))
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
               @endif
               <!-- Error Message -->
               @if($errors->any())
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
                  @endforeach
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
               @endif
               <div class="mfh-machine-profile" style="position: relative;">
                  <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="assestTabs" role="tablist">
                     @if(Auth::user()->employeeAssetOffice->isNotEmpty())

                     <li class="nav-item">
                        <a style="color: #0e0e0e;" id="assesttab" class="nav-link active"
                           data-bs-toggle="tab" href="#assestFormSection" role="tab"
                           aria-controls="assestFormSection" aria-selected="true">Assets</a>
                     </li>
                     @endif
                     @if($assets_requestss->isNotEmpty())
                     <li class="nav-item">
                        <a style="color: #0e0e0e;" id="assestapprovaldetails" class="nav-link"
                           data-bs-toggle="tab" href="#assestapproval" role="tab"
                           aria-controls="assestapproval" aria-selected="true">Approval Status</a>
                     </li>
                     @endif
                     <li class="nav-item">
                        <a style="color: #0e0e0e;" id="assestform" class="nav-link"
                           data-bs-toggle="tab" href="#assestformSections" role="tab"
                           aria-controls="assestformSections" aria-selected="true">Assets Application Form</a>
                     </li>
                     <li class="nav-item">
                        <a style="color: #0e0e0e;" id="assestvehciledetails" class="nav-link"
                           data-bs-toggle="tab" href="#assestvehcile" role="tab"
                           aria-controls="assestvehcile" aria-selected="true">Vehicle Information Form</a>
                     </li>
                     @if(Auth::user()->EmployeeID == '1602' ||  Auth::user()->EmployeeID == '1763' || Auth::user()->EmployeeID == '1707')
                     <li class="nav-item">
                        <a style="color: #0e0e0e;" id="assetsallrequestdetails" class="nav-link"
                           data-bs-toggle="tab" href="#assetsallrequest" role="tab"
                           aria-controls="assetsallrequest" aria-selected="true">All Assets Details</a>
                     </li>
                     @endif

                  </ul>
                  <div class="assets-help-doc"><a href=""><b> <i class="fas fa-info-circle"></i> Help Documents</b></a></div>
                  <div class="tab-content">
                     <!-- Query Form Section Tab -->
                     <div class="tab-pane fade show active" id="assestFormSection" role="tabpanel"
                        aria-labelledby="assesttab">
                        @if(Auth::user()->employeeAssetOffice->isNotEmpty())
                        <div class="card chart-card">
                           <div class="card-header">
                              <h4 class="has-btn">Official Assets</h4>
                           </div>
                           <div class="card-body table-responsive">
                              <table class="table">
                                 <thead class="thead-light" style="background-color:#f1f1f1;">
                                    <tr>
                                       <th>Sn</th>
                                       <th>Type of Asset</th>
                                       <th>Company</th>
                                       <th>Model Name</th>
                                       <th>Allocated Date</th>
                                       <th>Returned Date</th>
                                       <td>Details</td>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach(Auth::user()->employeeAssetOffice as $asset)
                                    <tr>
                                       <td>{{ $loop->index + 1 }}</td>
                                       @php
                                       // Query to fetch AssetName based on AssetId
                                       $assetName = \DB::table('hrm_asset_name') // Table name
                                       ->where('AssetNId', $asset->AssetNId) // Column name in hrm_asset_name
                                       ->value('AssetName'); // Get the value of AssetName directly
                                       @endphp
                                       <td>{{ $assetName ?? '-' }}</td>
                                       <td>{{ $asset->AComName ?? '-' }}</td>
                                       <td>{{ $asset->AModelName ?? '-' }}</td>
                                       <td>
                                          @if($asset->AAllocate && $asset->AAllocate != '0000-00-00' && $asset->AAllocate != '1970-01-01')
                                          {{ \Carbon\Carbon::parse($asset->AAllocate)->format('d-m-Y') }}
                                          @else
                                          -
                                          @endif
                                       </td>
                                       <td>
                                          @if($asset->ADeAllocate && $asset->ADeAllocate != '0000-00-00' && $asset->ADeAllocate != '1970-01-01')
                                          {{ \Carbon\Carbon::parse($asset->ADeAllocate)->format('d-m-Y') }}
                                          @else
                                          -
                                          @endif
                                       </td>
                                       <!--<td> <a href="#" data-bs-toggle="modal" data-bs-target="#viewOfficialAssetsModal" class="viewofficialassets"><i class="fas fa-eye"></i></a></td>-->
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        @endif
                     </div>
                     <!-- Employee Specific Query Section Tab -->
                     <div class="tab-pane fade" id="assestformSections" role="tabpanel"
                        aria-labelledby="assestform">
                        <div class="card">
                           <div class="card-header pb-0">
                              <h4 class="card-title">My Asset Request</h4>
                           </div>
                           <div class="card-content">
                              <div class="card-body">
                                 <div id="messageDiv"></div>
                                 <!-- Here the success/error messages will be displayed -->
                                 <form id="assetRequestForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                          <p>CC to your reporting manager & HOD</p>
                                       </div>
                                       <!-- Asset Name -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group s-opt">
                                             <label for="asset" class="col-form-label"><b>Select Asset Name <span
                                                      class="danger">*</span></b></label>
                                             <select class="select2 form-control select-opt" id="asset" name="asset">
                                                <option value="" disabled selected>Select Asset Name</option>
                                                @if ($mobileeligibility->Mobile_Hand_Elig === 'Y')
                                                <!-- Additional options for mobile eligibility -->
                                                <option value="11" data-limit="{{$mobileeliprice}}" data-type="Mobile Phone">Mobile Phone</option>
                                                <option value="12" data-limit="{{$mobileeliprice}}" data-type="Mobile Accessories">Mobile Accessories</option>
                                                <option value="18" data-limit="{{$mobileeliprice}}" data-type="Mobile Maintenance">Mobile Maintenance</option>
                                                @endif
                                                <!-- Dynamically populate options from $assets -->
                                                @foreach ($assets as $asset)
                                                <option value="{{ $asset->AssetNId }}" data-limit="{{ $asset->AssetELimit }}" data-type="{{ $asset->AssetName }}">
                                                   {{ $asset->AssetName }}
                                                </option>
                                                @endforeach
                                             </select>
                                             <span class="sel_arrow">
                                                <i class="fa fa-angle-down"></i>
                                             </span>
                                             <div class="invalid-feedback">Please select an asset name.</div>
                                          </div>
                                       </div>
                                       <!-- Maximum Limit -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="max_limit">
                                          <div class="form-group">
                                             <label for="maximum_limit" class="col-form-label"><b>Maximum Limit
                                                </b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter maximum limit" id="maximum_limit"
                                                name="maximum_limit" readonly>
                                          </div>
                                       </div>
                                       <!-- vehcile price -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehcile_price_id"
                                          style="display:none;">
                                          <div class="form-group">
                                             <label for="vehcile_price" class="col-form-label"><b>Vehicle price
                                                   <span class="danger">*</span></b></label>
                                             <input class="form-control" type="number"
                                                placeholder="Enter vehicle brand" id="vehcile_price"
                                                name="vehcile_price">
                                             <div class="invalid-feedback">Vehicle brand is required.</div>
                                          </div>
                                       </div>
                                       <!-- Model Name -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="model_name" class="col-form-label"><b>Model Name <span class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter model name" required
                                                id="model_name" name="model_name">
                                          </div>
                                       </div>
                                       <!-- Model Number -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="model_no" class="col-form-label"><b>Model Number </b></label>
                                             <input class="form-control" type="text" placeholder="Enter model number" id="model_no" name="model_no"
                                                maxlength="20">
                                             <div class="invalid-feedback">Model number is required and can only contain letters, numbers, and spaces.</div>
                                          </div>
                                       </div>
                                      
                                       <!-- Vehicle Brand -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_brand"
                                          style="display:none;">
                                          <div class="form-group">
                                             <label for="vehicle_brand" class="col-form-label"><b>Vehicle Brand
                                                   <span class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter vehicle brand" id="vehicle_brand"
                                                name="vehicle_brand">
                                             <div class="invalid-feedback">Vehicle brand is required.</div>
                                          </div>
                                       </div>
                                       <!-- Company Name -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="company_name_id">
                                          <div class="form-group">
                                             <label for="company_name" class="col-form-label"><b>Company Name
                                                   <span class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter company name" id="company_name" required
                                                name="company_name">
                                             <div class="invalid-feedback">Company name is required.</div>
                                          </div>
                                       </div>
                                       <!-- Purchase Date -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="purchase_date" class="col-form-label"><b>Purchase Date
                                                   <span class="danger">*</span></b></label>
                                             <input class="form-control" type="date" placeholder="Purchase Date"
                                                id="purchase_date" name="purchase_date" required
                                                max="{{ date('Y-m-d') }}">
                                             <div class="invalid-feedback">Purchase date is required.</div>
                                          </div>
                                       </div>
                                       <!-- Dealer Name -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="dealer_name" class="col-form-label"><b>Dealer Name <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter dealer name" id="dealer_name" required
                                                name="dealer_name">
                                             <div class="invalid-feedback">Dealer name is required.</div>
                                          </div>
                                       </div>
                                       <!-- Dealer Contact -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="dealer_contact" class="col-form-label"><b>Dealer Contact </b></label>
                                             <input class="form-control" type="number"
                                                placeholder="Enter dealer contact number" id="dealer_contact"
                                                name="dealer_contact" pattern="^\d{10}$|^\d{12}$"
                                                title="Please enter a valid 10 or 12 digit phone number."
                                                oninput="validatePhoneNumber()">
                                             <small id="phoneError" class="form-text text-danger"
                                                style="display:none;">Please enter a valid 10 or 12 digit phone
                                                number.</small>
                                          </div>
                                       </div>
                                       <!-- Price -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="price" class="col-form-label"><b>Price <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="number" required placeholder="Enter price"
                                                id="price" name="price">
                                             <div class="invalid-feedback">Price is required.</div>
                                          </div>
                                       </div>
                                       <!-- Bill Number -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="bill_number" class="col-form-label"><b>Bill Number <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter bill number" id="bill_number" required
                                                name="bill_number">
                                             <div class="invalid-feedback">Bill number is required.</div>
                                          </div>
                                       </div>
                                       <!-- Request Amount -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="request_amont_id">
                                          <div class="form-group">
                                             <label for="request_amount" class="col-form-label"><b>Request Amount
                                                   <span class="danger">*</span></b> </label>
                                             <input class="form-control" type="number" required
                                                placeholder="Enter request amount" id="request_amount"
                                                name="request_amount">
                                             <div class="invalid-feedback">Request amount is required.</div>
                                          </div>
                                       </div>
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="imei_field">
                                          <div class="form-group">
                                             <label for="iemi_no" class="col-form-label"><b>IMEI No.:</b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter IMEI number" id="iemi_no" name="iemi_no">
                                          </div>
                                       </div>
                                       <!-- Bill Copy -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="bill_copy" class="col-form-label"><b>Bill Copy <span
                                                      class="danger">*</span></b></label>
                                             <small class="text-danger" style="margin-left: 5px;">Max: 2MB(2000KB)</small>

                                             <input class="form-control" id="bill_copy" name="bill_copy"
                                                type="file" required />
                                             <div class="invalid-feedback">Bill copy is required.</div>
                                          </div>
                                       </div>
                                       <!-- Asset Copy -->
                                       <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12" id="asset_id">
                                          <div class="form-group">
                                             <label for="asset_copy" class="col-form-label"><b>Asset Copy <span
                                                      class="danger">*</span></b></label>
                                             <small class="text-danger" style="margin-left: 5px;">Max: 2MB(2000KB)</small>

                                             <input class="form-control" id="asset_copy" name="asset_copy"
                                                type="file" />
                                             <div class="invalid-feedback">Asset copy is required.</div>
                                          </div>
                                       </div>
                                       <!-- Vehicle Photo (hidden by default) -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12"
                                          id="vehicle_photo_field" style="display:none;">
                                          <div class="form-group">
                                             <label for="vehicle_photo" class="col-form-label"><b>Vehicle Photo
                                                   <span class="danger">*</span></b></label>
                                             <input class="form-control" id="vehicle_photo" name="vehicle_photo"
                                                type="file" accept="image/*">
                                             <div class="invalid-feedback">Vehicle photo is required.</div>
                                          </div>
                                       </div>
                                       <!-- Fuel Type -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_fuel"
                                          style="display:none;">
                                          <div class="form-group s-opt">
                                             <label for="fuel_type" class="col-form-label"><b>Fuel Type <span
                                                      class="danger">*</span></b></label>
                                             <select class="select2 form-control select-opt" id="fuel_type" name="fuel_type">
                                                <option value="" disabled selected>Select Fuel Type</option>
                                                <option value="petrol">Petrol</option>
                                                <option value="diesel">Diesel</option>
                                                <option value="electric">Electric</option>
                                                <option value="cng">CNG</option>
                                             </select>
                                             <span class="sel_arrow">
                                                <i class="fa fa-angle-down"></i>
                                             </span>
                                             <div class="invalid-feedback">Fuel type is required.</div>
                                          </div>
                                       </div>
                                       <!-- Registration Number -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_regno"
                                          style="display:none;">
                                          <div class="form-group">
                                             <label for="registration_number"
                                                class="col-form-label"><b>Registration Number <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter registration number" id="registration_number"
                                                name="registration_number">
                                             <div class="invalid-feedback">Registration number is required.</div>
                                          </div>
                                       </div>
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_regdate"
                                          style="display:none;">
                                          <div class="form-group">
                                             <label for="registration_date"
                                                class="col-form-label"><b>Registration Date <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="date"
                                                placeholder="Enter registration number" id="registration_date"
                                                name="registration_date">
                                             <div class="invalid-feedback">Registration number is required.</div>
                                          </div>
                                       </div>
                                       <!-- DL Copy -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_dl"
                                          style="display:none;">
                                          <div class="form-group">
                                             <label for="dl_copy" class="col-form-label"><b>DL Copy <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" id="dl_copy" name="dl_copy" type="file">
                                             <div class="invalid-feedback">DL copy is required.</div>
                                          </div>
                                       </div>
                                       <!-- RC Copy -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_rl"
                                          style="display:none;">
                                          <div class="form-group">
                                             <label for="rc_copy" class="col-form-label"><b>RC Copy <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" id="rc_copy" name="rc_copy" type="file">
                                             <div class="invalid-feedback">RC copy is required.</div>
                                          </div>
                                       </div>
                                       <!-- Insurance Copy -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_ins"
                                          style="display:none;">
                                          <div class="form-group">
                                             <label for="insurance_copy" class="col-form-label"><b>Insurance Copy
                                                   <span class="danger">*</span></b></label>
                                             <input class="form-control" id="insurance_copy"
                                                name="insurance_copy" type="file">
                                             <div class="invalid-feedback">Insurance copy is required.</div>
                                          </div>
                                       </div>
                                       <!-- Odometer Reading -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_odo"
                                          style="display:none;">
                                          <div class="form-group">
                                             <label for="odometer_reading" class="col-form-label"><b>1st Odometer
                                                   Reading image <span class="danger">*</span></b></label>
                                             <input class="form-control" type="file"
                                                placeholder="Enter odometer reading" id="odometer_reading"
                                                name="odometer_reading">
                                             <div class="invalid-feedback">Odometer reading is required.</div>
                                          </div>
                                       </div>
                                       <!-- Odometer Reading current -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_odo_current"
                                          style="display:none;">
                                          <div class="form-group">
                                             <label for="currentodometer_reading" class="col-form-label"><b>Current Odometer
                                                   Reading <span class="danger">*</span></b></label>
                                             <input class="form-control" type="number"
                                                placeholder="Enter odometer reading" id="currentodometer_reading"
                                                name="currentodometer_reading">
                                             <div class="invalid-feedback">Odometer reading is required.</div>
                                          </div>
                                       </div>
                                       <!-- Ownership -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_owner"
                                          style="display:none;">
                                          <div class="form-group s-opt">
                                             <label for="ownership" class="col-form-label"><b>Ownership <span
                                                      class="danger">*</span></b></label>
                                             <select class="select2 form-control select-opt" id="ownership" name="ownership">
                                                <option value="" disabled selected>Select Ownership</option>
                                                <option value="1">1st</option>
                                                <option value="2">2nd</option>
                                                <option value="3">3rd</option>
                                             </select>
                                             <span class="sel_arrow">
                                                <i class="fa fa-angle-down"></i>
                                             </span>
                                             <div class="invalid-feedback">Ownership is required.</div>
                                          </div>
                                       </div>
                                       <!-- Remarks -->
                                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="remarks" class="col-form-label"><b>Remarks</b></label>
                                             <textarea class="form-control" id="remarks" name="remarks" rows="4"
                                                placeholder="Enter any remarks"></textarea>
                                             <div class="invalid-feedback">Remarks are optional.</div>
                                          </div>
                                       </div>
                                       <!-- Declaration Section -->
                                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                                          <div class="card">
                                             <div class="card-body">
                                                <h5 class="mb-3"><b>Declaration</b></h5>
                                                <ol style="padding-left: 1rem;">
                                                   <li>I have purchased the above-mentioned asset for official use on the date specified in the invoice. The purchase invoice is in my name and is attached above.</li>
                                                   <li>This is my asset and has not been transferred to the ownership of the company.</li>
                                                   <li>The asset is used substantially and primarily for business purposes in the course of performing my official duties.</li>
                                                   <li>I have read and understood the company’s policy on asset reimbursements and agree to abide by its terms and conditions.</li>
                                                   <li>In the event of separation from the company, or if any internal policy violation is found, I agree to cooperate fully with the company’s recovery process.</li>
                                                   <li>This declaration is being submitted electronically through my official ESS account and shall be deemed valid, legally binding, and subject to audit.</li>
                                                   <li>This expense is being claimed under <b>Section 37(1)</b> of the Income Tax Act, 1961, as it is wholly and exclusively incurred for business purposes.</li>
                                                   <li>I agree to indemnify and keep indemnified the company against any liability, loss, or damage arising from any false declaration, misrepresentation, or misuse related to this reimbursement.</li>
                                                </ol>

                                                <!-- Checkbox -->
                                                <div class="form-check mt-3">
                                                   <input class="form-check-input" type="checkbox" name="declaration_agreed" id="declaration_agreed" required>
                                                   <label class="form-check-label" for="declaration_agreed">
                                                     I have read and agree to the above declaration for asset reimbursement.
                                                   </label>
                                                   <div class="invalid-feedback">You must agree to the declaration before submitting.</div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- Form Actions -->
                                       <div class="form-group mb-0" id="form-actions" style="display:none;">
                                          <button class="btn btn-primary" type="reset">Reset</button>
                                          <button class="btn btn-success" type="submit">Submit</button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                        @if(Auth::user()->employeeAssetReq->isNotEmpty())
                        <div class="card chart-card">
                           <div class="card-header">
                              <h4 class="has-btn">Request Status</h4>
                           </div>
                           <div class="card-body table-responsive">
                              <table class="table">
                                 <thead class="thead-light" style="background-color:#f1f1f1;">
                                    <tr>
                                       <th>Sn</th>
                                       <th>Request Date</th>
                                       <th>Type of Asset</th>
                                       <!--<th>Balance Amount</th>-->
                                       <th class="text-right">Request Amount</th>
                                       <th class="text-right">Acct. Approval Amount</th>
                                       <th class="text-center">Bill Copy</th>
                                       <th class="text-center">Asset Copy</th>
                                       <th>Reporting Remarks</th>
                                       <th class="text-center">Status</th>
                                       <th class="text-center">Details</th>
                                       <th class="text-center">History</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach(Auth::user()->employeeAssetReq as $index => $request)
                                    <tr>
                                       <td>{{ $index + 1 }}</td>
                                       <td>{{ \Carbon\Carbon::parse($request->ReqDate)->format('d M Y') }}
                                       </td>
                                       @php
                                       // Query to fetch AssetName based on AssetId
                                       $assetName = \DB::table('hrm_asset_name') // Table name
                                       ->where('AssetNId', $request->AssetNId) // Column name in hrm_asset_name
                                       ->value('AssetName'); // Field to retrieve
                                       @endphp
                                       <td>{{ $assetName ?? 'N/A' }}</td>
                                       <!-- Display AssetName -->
                                       <!--<td>-->
                                       <!--</td>-->
                                       <td class="text-right"><b>{{ number_format($request->ReqAmt) }}/-</b></td>
                                       <td class="text-right"><b>{{ number_format($request->ApprovalAmt) }}/-</b></td>
                                       <td class="text-center">
                                          @if($request->ReqBillImgExtName != '')
                                          <!-- Check if it's a PDF -->
                                          @if(str_ends_with($request->ReqBillImgExtName, '.pdf'))
                                          <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                             
                                             data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->ReqBillImgExtName) }}"

                                             data-file-type="bill">
                                             <i class="fas fa-eye me-2"></i>
                                          </a>
                                          @else
                                          <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
                                             data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->ReqBillImgExtName) }}"
                                             data-file-type="bill">
                                             <i class="fas fa-eye me-2"></i>
                                          </a>
                                          @endif
                                          @else
                                          <span>No Bill</span>
                                          <form action="{{ route('asset.upload') }}" style="display:none;" method="POST" enctype="multipart/form-data">
                                             @csrf
                                             <input type="file" name="bill_copy" accept=".jpg,.jpeg,.png,.pdf" required>
                                             <input type="hidden" name="request_id" value="{{ $request->AssetEmpReqId }}">
                                             <input type="hidden" name="employee_id" value="{{ $request->EmployeeID }}">

                                             <button type="submit" class="btn btn-sm btn-primary mt-1">Upload Bill</button>
                                          </form>
                                          @endif
                                       </td>
                                       <td class="text-center">
                                          @if($request->ReqAssestImgExtName)
                                          <!-- Check if it's a PDF -->
                                          @if(str_ends_with($request->ReqAssestImgExtName, '.pdf'))
                                          <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                             data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqAssestImgExtName) }}"
                                             data-file-type="asset">
                                             <i class="fas fa-eye me-2"></i>
                                          </a>
                                          @else
                                          <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
                                          data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqAssestImgExtName) }}"
                                             data-file-type="asset">
                                             <i class="fas fa-eye me-2"></i>
                                          </a>
                                          @endif
                                          @else
                                          <span>No Asset</span>
                                          <form action="{{ route('asset.upload') }}" style="display:none;" method="POST" enctype="multipart/form-data">
                                             @csrf
                                             <input type="file" name="asset_copy" accept=".jpg,.jpeg,.png,.pdf" required>
                                             <input type="hidden" name="request_id" value="{{ $request->AssetEmpReqId }}">
                                             <input type="hidden" name="employee_id" value="{{ $request->EmployeeID }}">

                                             <button type="submit" class="btn btn-sm btn-primary mt-1">Upload Asset</button>
                                          </form>
                                          @endif
                                       </td>
                                       <td>{{ $request->HODRemark }}</td>
                                       <td class="text-center">
                                          <!-- View button to show approval status -->
                                          <button type="button" style="padding:3px 11px;font-size: 11px;"
                                             class="btn-outline success-outline sm-btn"
                                             data-request-id="{{ $request->AssetEmpReqId }}"
                                             onclick="toggleApprovalView({{ $request->AssetEmpReqId }})">
                                             View Status
                                          </button>
                                       </td>
                                       <td class="text-center">
                                          <a href="#" data-bs-toggle="modal" data-bs-target="#viewassetsModal" onclick="viewAssetsModalFun({{ $request->AssetEmpReqId }})" class="viewassets">
                                             <i class="fas fa-eye"></i>
                                          </a>
                                       </td>
                                       <td class="text-center">
                                          <a href="#"
                                             data-bs-toggle="modal"
                                             data-bs-target="#viewassetsHistoryModal"
                                             class="viewassetsHistory"
                                             data-employee-id="{{ $request->EmployeeID }}"
                                             data-employee-name="{{ $request->Fname . ' ' . $request->Sname . ' ' . $request->Lname }}"
                                             data-employee-code="{{ $request->EmpCode }}">
                                             <i class="fas fa-history"></i>
                                          </a>

                                       </td>
                                    </tr>
                                    <tr id="approval-row-{{ $request->AssetEmpReqId }}" style="display:none;">
                                       <td colspan="5">
                                          <!-- Display approval sections horizontally -->
                                          <div class="approval-status" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0;">
                                             <!-- HOD Approval Section -->
                                             <div class="approval-item" style="text-align: center; position: relative; width: 30%;">
                                                <!-- Circle for HOD -->
                                                <span @if($request->HODApprovalStatus == 2)
                                                   style="background-color: #0d9137;margin-top:25px;"
                                                   @else
                                                   style="background-color: #dba62f;margin-top:25px;"
                                                   @endif
                                                   class="exp-round"
                                                   style="border-radius: 50%; width: 30px; height: 30px; display: inline-block; margin-bottom: 10px;margin-top:25px;"></span>
                                                <div class="approval-details" style="padding-top: 10px;padding-left:15px;">
                                                   <h6>@if($request->HODApprovalStatus == 2) Level 1 @else Pending HOD Approval @endif</h6>
                                                   <p>HOD/Reporting Section</p>
                                                   <p>{{ \Carbon\Carbon::parse($request->HODSubDate)->format('d M Y')?? 'Date Not Available' }}</p>
                                                   <p>{{ $request->HODRemark ?? 'No Remarks' }}</p>
                                                </div>
                                                <!-- Connecting Line -->
                                                <div class="line" style="position: absolute; top: 50%; left: 100%; width: 50px; height: 2px; background-color: #ccc;"></div>
                                             </div>
                                             <!-- IT Approval Section -->
                                             <div class="approval-item" style="text-align: center; position: relative; width: 30%;">
                                                <!-- Circle for IT -->
                                                <span @if($request->ITApprovalStatus == 2)
                                                   style="background-color: #0d9137;margin-top:34px;"
                                                   @else
                                                   style="background-color: #dba62f;margin-top:24px;"
                                                   @endif
                                                   class="exp-round"
                                                   style="border-radius: 50%; width: 30px; height: 30px; display: inline-block; margin-bottom: 10px;margin-top:34px;"></span>
                                                <div class="approval-details" style="padding-top: 10px;margin-left:20px;">
                                                   <h6>@if($request->ITApprovalStatus == 2) Level 2 @else Pending IT Approval @endif</h6>
                                                   <p>IT Section</p>
                                                   <p>{{\Carbon\Carbon::parse($request->ITSubDate)->format('d M Y')?? 'Date Not Available' }}</p>
                                                   <p>{{ $request->ITRemark ?? 'No Remarks' }}</p>
                                                </div>
                                                <!-- Connecting Line -->
                                                <div class="line" style="position: absolute; top: 50%; left: 100%; width: 50px; height: 2px; background-color: #ccc;"></div>
                                             </div>
                                             <!-- Accounts Approval Section -->
                                             <div class="approval-item" style="text-align: center; position: relative; width: 30%;">
                                                <!-- Circle for Accounts -->
                                                <span @if($request->AccPayStatus == 2)
                                                   style="background-color: #0d9137;margin-top:34px;"
                                                   @else
                                                   style="background-color: #dba62f;margin-top:24px;"
                                                   @endif
                                                   class="exp-round"
                                                   style="border-radius: 50%; width: 30px; height: 30px; display: inline-block; margin-bottom: 10px;margin-top:34px;"></span>
                                                <div class="approval-details" style="padding-top: 10px;margin-left:20px;">
                                                   <h6>@if($request->AccPayStatus == 2) Level 3 @else Pending Accounts Approval @endif</h6>
                                                   <p>Accounts Section</p>
                                                   <p>{{ \Carbon\Carbon::parse($request->AccSubDate)->format('d M Y') ?? 'Date Not Available' }}</p>
                                                   <p>{{ $request->AccRemark ?? 'No Remarks' }}</p>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        @endif
                     </div>
                     <!-- Employee Specific Query Section Tab -->
                     <!-- Employee Specific Query Section Tab -->
                     <div class="tab-pane fade" id="assestvehcile" role="tabpanel"
                        aria-labelledby="assestvehciledetails">
                        <div class="card">
                           <div class="card-header pb-0">
                              <h4 class="card-title">My vehcile Details</h4>
                           </div>
                           <div class="card-content">
                              <div class="card-body">
                                 <div id="messageDiv"></div>
                                 <!-- Here the success/error messages will be displayed -->
                                 <form id="assetRequestFormVehcile" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                          <p>CC to your reporting manager & HOD</p>
                                       </div>
                                       <input type="hidden" id="employeeid" name="EmployeeID" value="{{Auth::user()->EmployeeID}}">
                                       <input type="hidden" id="empcode" name="EmpCode" value="{{Auth::user()->EmpCode}}">
                                       <!-- Vehicle Type Dropdown -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group s-opt">
                                             <label for="vehicle_typenew" class="col-form-label"><b>Select Vehicle Type <span class="danger">*</span></b></label>
                                             <select class="select2 form-control select-opt" id="vehicle_type" name="vehicle_typenew">
                                                <option value="" disabled selected>Select Vehicle Type</option>
                                                <option value="2-wheeler" data-name="2-Wheeler" data-id="2w">2 Wheeler</option>
                                                <option value="4-wheeler" data-name="4-Wheeler" data-id="4w">4 Wheeler</option>
                                             </select>
                                             <span class="sel_arrow">
                                                <i class="fa fa-angle-down"></i>
                                             </span>
                                          </div>
                                       </div>
                                       <!-- Model Name -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="model_name" class="col-form-label"><b>Model Name</b> </label>
                                             <input class="form-control" type="text" placeholder="Enter model name" id="model_name" name="model_name">
                                             <div class="invalid-feedback">Model name is required.</div>
                                          </div>
                                       </div>
                                       <!-- Model Name -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="model_no" class="col-form-label"><b>Model Number <span class="danger">*</span></b></label>
                                             <input class="form-control" type="text" required placeholder="Enter model name" id="model_no" name="model_no">
                                             <div class="invalid-feedback">Model name is required.</div>
                                          </div>
                                       </div>
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="vehicle_brand" class="col-form-label"><b>Vehicle Brand
                                                   <span class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter vehicle brand" id="vehicle_brand" required
                                                name="vehicle_brand">
                                             <div class="invalid-feedback">Vehicle brand is required.</div>
                                          </div>
                                       </div>
                                       <!-- Dealer Name -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="dealer_name" class="col-form-label"><b>Dealer Name <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter dealer name" id="dealer_name" required
                                                name="dealer_name">
                                             <div class="invalid-feedback">Dealer name is required.</div>
                                          </div>
                                       </div>
                                       <!-- Dealer Contact -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="dealer_contact" class="col-form-label"><b>Dealer Contact
                                                   <span class="danger">*</span></b></label>
                                             <input class="form-control" type="number"
                                                placeholder="Enter dealer contact number" id="dealer_contact"
                                                name="dealer_contact" required pattern="^\d{10}$|^\d{12}$"
                                                title="Please enter a valid 10 or 12 digit phone number."
                                                oninput="validatePhoneNumber()">
                                             <small id="phoneError" class="form-text text-danger"
                                                style="display:none;">Please enter a valid 10 or 12 digit phone
                                                number.</small>
                                          </div>
                                       </div>
                                       <!-- Price -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="price" class="col-form-label"><b>Price <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="number" placeholder="Enter price"
                                                id="price" name="price" required>
                                             <div class="invalid-feedback">Price is required.</div>
                                          </div>
                                       </div>
                                       <!-- Bill Number -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="bill_number" class="col-form-label"><b>Bill Number <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter bill number" id="bill_number" required
                                                name="bill_number">
                                             <div class="invalid-feedback">Bill number is required.</div>
                                          </div>
                                       </div>
                                       <!-- Vehicle Brand -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="vehicle_brandnew" class="col-form-label"><b>Vehicle Brand <span class="danger">*</span></b></label>
                                             <input class="form-control" type="text" placeholder="Enter vehicle brand" id="vehicle_brandnew" name="vehicle_brandnew">
                                             <div class="invalid-feedback">Vehicle brand is required.</div>
                                          </div>
                                       </div>
                                       <!-- Bill Copy -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="bill_copy" class="col-form-label"><b>Bill Copy <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" id="bill_copy" name="bill_copy" required
                                                type="file" />
                                             <div class="invalid-feedback">Bill copy is required.</div>
                                          </div>
                                       </div>
                                       <!-- Vehicle Photo (hidden by default) -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="vehicle_photonew" class="col-form-label"><b>Vehicle Photo <span class="danger">*</span></b></label>
                                             <input class="form-control" id="vehicle_photo" name="vehicle_photonew" type="file" accept="image/*" required>
                                             <div class="invalid-feedback">Vehicle photo is required.</div>
                                          </div>
                                       </div>
                                       <!-- Fuel Type (conditional) -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group s-opt">
                                             <label for="fuel_typenew" class="col-form-label"><b>Fuel Type <span class="danger">*</span></b></label>
                                             <select class="select2 form-control select-opt" id="fuel_typenew" name="fuel_typenew">
                                                <option value="" disabled selected>Select Fuel Type</option>
                                                <option value="petrol">Petrol</option>
                                                <option value="diesel">Diesel</option>
                                                <option value="electric">Electric</option>
                                                <option value="cng">CNG</option>
                                             </select>
                                             <span class="sel_arrow">
                                                <i class="fa fa-angle-down"></i>
                                             </span>
                                             <div class="invalid-feedback">Fuel type is required.</div>
                                          </div>
                                       </div>
                                       <!-- Registration Number -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_regno">
                                          <div class="form-group">
                                             <label for="registration_number"
                                                class="col-form-label"><b>Registration Number <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="text"
                                                placeholder="Enter registration number" id="registration_number" required
                                                name="registration_number">
                                             <div class="invalid-feedback">Registration number is required.</div>
                                          </div>
                                       </div>
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_regdate">
                                          <div class="form-group">
                                             <label for="registration_date"
                                                class="col-form-label"><b>Registration Date <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" type="date"
                                                placeholder="Enter registration number" id="registration_date" required
                                                name="registration_date">
                                             <div class="invalid-feedback">Registration number is required.</div>
                                          </div>
                                       </div>
                                       <!-- DL Copy -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_dl">
                                          <div class="form-group">
                                             <label for="dl_copy" class="col-form-label"><b>DL Copy <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" id="dl_copy" name="dl_copy" type="file" required>
                                             <div class="invalid-feedback">DL copy is required.</div>
                                          </div>
                                       </div>
                                       <!-- RC Copy -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_rl">
                                          <div class="form-group">
                                             <label for="rc_copy" class="col-form-label"><b>RC Copy <span
                                                      class="danger">*</span></b></label>
                                             <input class="form-control" id="rc_copy" name="rc_copy" type="file" required>
                                             <div class="invalid-feedback">RC copy is required.</div>
                                          </div>
                                       </div>
                                       <!-- Insurance Copy -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_ins">
                                          <div class="form-group">
                                             <label for="insurance_copy" class="col-form-label"><b>Insurance Copy
                                                   <span class="danger">*</span></b></label>
                                             <input class="form-control" id="insurance_copy"
                                                name="insurance_copy" type="file" required>
                                             <div class="invalid-feedback">Insurance copy is required.</div>
                                          </div>
                                       </div>
                                       <!-- Ownership -->
                                       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                          <div class="form-group s-opt">
                                             <label for="ownership" class="col-form-label"><b>Ownership <span class="danger">*</span></b></label>
                                             <select class="select2 form-control select-opt" id="ownershipnew" name="ownershipnew" required>
                                                <option value="" disabled selected>Select Ownership</option>
                                                <option value="1">1st</option>
                                                <option value="2">2nd</option>
                                                <option value="3">3rd</option>
                                             </select>
                                             <span class="sel_arrow">
                                                <i class="fa fa-angle-down"></i>
                                             </span>
                                             <div class="invalid-feedback">Ownership is required.</div>
                                          </div>
                                       </div>
                                       <!-- Remarks -->
                                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                          <div class="form-group">
                                             <label for="remarksnew" class="col-form-label"><b>Remarks</b></label>
                                             <textarea class="form-control" id="remarksnew" name="remarksnew" rows="4" placeholder="Enter any remarks"></textarea>
                                             <div class="invalid-feedback">Remarks are optional.</div>
                                          </div>
                                       </div>
                                       <!-- Form Actions -->
                                       <div class="form-group mb-0">
                                          <button class="btn btn-primary" type="reset">Reset</button>
                                          <button class="btn btn-success" type="submit">Submit</button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                              @if(Auth::user()->employeeAssetvehcileReq->isNotEmpty())
                              <div class="card chart-card">
                                 <div class="card-header">
                                    <h4 class="has-btn">Vehcile Details</h4>
                                 </div>
                                 <div class="card-body table-responsive">
                                    <table class="table">
                                       <thead class="thead-light" style="background-color:#f1f1f1;">
                                          <tr>
                                             <!-- Additional columns for full details -->
                                             <th>SN</th>
                                             <th>Brand Name</th>
                                             <th>Model Name</th>
                                             <th>Model No.</th>
                                             <th>Dealer Name</th>
                                             <th>Dealer Contact</th>
                                             <th>Purchase Date</th>
                                             <th>Price</th>
                                             <th>Registration No.</th>
                                             <th>Registration Date</th>
                                             <th>Bill No.</th>
                                             <!-- <th>Invoice</th> -->
                                             <th>Fuel Type</th>
                                             <th>Ownership</th>
                                             <th class="text-center">Vehicle Image</th>
                                             <th class="text-center">RC File</th>
                                             <th class="text-center">Insurance</th>
                                             <th>Remark</th>
                                             <th>HR Approval</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach(Auth::user()->employeeAssetvehcileReq as $index => $request)
                                          <tr>
                                             <td>{{ $index + 1 }}</td>

                                             <!-- 2-Wheeler Specific Columns -->
                                             @if($request->vehicle_type == '2-wheeler')
                                             <td>{{ $request->brand ?? '-' }}</td>
                                             <td>{{ $request->model_name ?? '-' }}</td>
                                             <td>{{ $request->model_no ?? '-' }}</td>
                                             <td>{{ $request->dealer_name ?? '-' }}</td>
                                             <td>{{ $request->dealer_contact ?? '-' }}</td>
                                             <td>{{ \Carbon\Carbon::parse($request->purchase_date)->format('d M Y') ?? '-' }}</td>
                                             <td>{{ number_format($request->price, 2) ?? '-' }}</td>
                                             <td>{{ $request->registration_no ?? '-' }}</td>
                                             <td>{{ \Carbon\Carbon::parse($request->registration_date)->format('d M Y') ?? '-' }}</td>
                                             <td>{{ $request->bill_no ?? '-' }}</td>
                                             <!-- <td>{{ $request->invoice ?? '-' }}</td> -->
                                             <td>{{ $request->fuel_type ?? '-' }}</td>
                                             <td>{{ $request->ownership ?? '-' }}</td>

                                             <!-- Vehicle Image Column -->
                                             <td class="text-center">
                                                @if($request->vehicle_image != '')
                                                @if(str_ends_with($request->vehicle_image, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->vehicle_image) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->vehicle_image) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No Vehicle image</span>
                                                @endif
                                             </td>

                                             <!-- RC File Column -->
                                             <td class="text-center">
                                                @if($request->rc_file != '')
                                                @if(str_ends_with($request->rc_file, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->rc_file) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->rc_file) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No RC image</span>
                                                @endif
                                             </td>

                                             <!-- Insurance File Column -->
                                             <td class="text-center">
                                                @if($request->insurance != '')
                                                @if(str_ends_with($request->insurance, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->insurance) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->insurance) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No insurance image</span>
                                                @endif
                                             </td>

                                             <td>{{ $request->remark ?? '-' }}</td>

                                             @php
                                             $hr_approved = ($request->hr_approval == 'Y') ? 'Approved' : (($request->hr_approval == 'N') ? 'Reject' : 'Pending');
                                             @endphp
                                             <td>{{ $hr_approved }}</td>

                                             <!-- 2-Wheeler Specific Edit Button -->
                                             <td>
                                                <button class="btn badge-primary edit-btn"
                                                   data-id="{{ $request->id }}"
                                                   data-employee-id="{{ $request->EmployeeID }}"
                                                   data-wheeler="{{ $request->vehicle_type }}"
                                                   data-emp-code="{{ $request->EmpCode }}"
                                                   data-brand="{{ $request->brand }}"
                                                   data-model-name="{{ $request->model_name }}"
                                                   data-model-no="{{ $request->model_no }}"
                                                   data-dealer-name="{{ $request->dealer_name }}"
                                                   data-dealer-contact="{{ $request->dealer_contact }}"
                                                   data-purchase-date="{{ $request->purchase_date }}"
                                                   data-price="{{ $request->price }}"
                                                   data-registration-no="{{ $request->registration_no }}"
                                                   data-registration-date="{{ $request->registration_date }}"
                                                   data-bill-no="{{ $request->bill_no }}"
                                                   data-invoice="{{ $request->invoice }}"
                                                   data-fuel-type="{{ $request->fuel_type }}"
                                                   data-ownership="{{ $request->ownership }}"
                                                   data-vehicle-image="{{ $request->vehicle_image }}"
                                                   data-rc-file="{{ $request->rc_file }}"
                                                   data-insurance="{{ $request->insurance }}"
                                                   data-remark="{{ $request->remark }}"
                                                   @if($request->hr_approval == 'Y') disabled @endif>
                                                   Edit
                                                </button>
                                             </td>

                                             @endif

                                             <!-- 4-Wheeler Specific Columns -->
                                             @if($request->vehicle_type == '4-wheeler')
                                             <td>{{ $request->four_brand ?? '-' }}</td>
                                             <td>{{ $request->four_model_name ?? '-' }}</td>
                                             <td>{{ $request->four_model_no ?? '-' }}</td>
                                             <td>{{ $request->four_dealer_name ?? '-' }}</td>
                                             <td>{{ $request->four_dealer_contact ?? '-' }}</td>
                                             <td>{{ \Carbon\Carbon::parse($request->four_purchase_date)->format('d M Y') ?? '-' }}</td>
                                             <td>{{ number_format($request->four_price, 2) ?? '-' }}</td>
                                             <td>{{ $request->four_registration_no ?? '-' }}</td>
                                             <td>{{ \Carbon\Carbon::parse($request->four_registration_date)->format('d M Y') ?? '-' }}</td>
                                             <td>{{ $request->four_bill_no ?? '-' }}</td>
                                             <!-- <td>{{ $request->four_invoice ?? '-' }}</td> -->
                                             <td>{{ $request->four_fuel_type ?? '-' }}</td>
                                             <td>{{ $request->four_ownership ?? '-' }}</td>

                                             <!-- Vehicle Image Column -->
                                             <td class="text-center">
                                                @if($request->four_vehicle_image != '')
                                                @if(str_ends_with($request->four_vehicle_image, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->four_vehicle_image) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->four_vehicle_image) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No Vehicle image</span>
                                                @endif
                                             </td>

                                             <!-- RC File Column -->
                                             <td class="text-center">
                                                @if($request->four_rc_file != '')
                                                @if(str_ends_with($request->four_rc_file, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->four_rc_file) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->four_rc_file) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No RC image</span>
                                                @endif
                                             </td>

                                             <!-- Insurance File Column -->
                                             <td class="text-center">
                                                @if($request->four_insurance != '')
                                                @if(str_ends_with($request->four_insurance, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->four_insurance) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal" data-file-url="{{ url('/file-view/Employee_Assets/' . Auth::user()->CompanyId . '/' . $request->four_insurance) }}" data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No insurance image</span>
                                                @endif
                                             </td>

                                             <td>{{ $request->remark ?? '-' }}</td>

                                             @php
                                             $hr_approved = ($request->hr_approval == 'Y') ? 'Approved' : (($request->hr_approval == 'N') ? 'Reject' : 'Pending');
                                             @endphp
                                             <td>{{ $hr_approved }}</td>

                                             <!-- 4-Wheeler Specific Edit Button -->
                                             <td>
                                                <button class="btn badge-primary edit-btn"
                                                   data-id="{{ $request->id }}"
                                                   data-employee-id="{{ $request->EmployeeID }}"
                                                   data-wheeler="{{ $request->vehicle_type }}"
                                                   data-emp-code="{{ $request->EmpCode }}"
                                                   data-four-brand="{{ $request->four_brand }}"
                                                   data-four-model-name="{{ $request->four_model_name }}"
                                                   data-four-model-no="{{ $request->four_model_no }}"
                                                   data-four-dealer-name="{{ $request->four_dealer_name }}"
                                                   data-four-dealer-contact="{{ $request->four_dealer_contact }}"
                                                   data-four-purchase-date="{{ $request->four_purchase_date }}"
                                                   data-four-price="{{ $request->four_price }}"
                                                   data-four-registration-no="{{ $request->four_registration_no }}"
                                                   data-four-registration-date="{{ $request->four_registration_date }}"
                                                   data-four-bill-no="{{ $request->four_bill_no }}"
                                                   data-four-invoice="{{ $request->four_invoice }}"
                                                   data-four-fuel-type="{{ $request->four_fuel_type }}"
                                                   data-four-ownership="{{ $request->four_ownership }}"
                                                   data-four-vehicle-image="{{ $request->four_vehicle_image }}"
                                                   data-four-rc-file="{{ $request->four_rc_file }}"
                                                   data-four-insurance="{{ $request->four_insurance }}"
                                                   data-remark="{{ $request->remark }}"
                                                   @if($request->hr_approval == 'Y') disabled @endif>
                                                   Edit
                                                </button>
                                             </td>
                                             @endif
                                          </tr>
                                          @endforeach

                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>
                     <!-- Employee Specific Query Section Tab -->
                     <div class="tab-pane fade" id="assestapproval" role="tabpanel"
                        aria-labelledby="assestapprovaldetails">
                        <div class="card">
                           <div class="card-content">
                              @if($assets_requestss->isNotEmpty())
                              <div class="card chart-card">
                                 <div class="card-header">
                                    <div class="dflex justify-content-center align-items-center">
                                       <h4 class="has-btn">Approval Status</h4>
                                       <form method="GET" action="{{ url()->current() }}" style="margin-left: 15px;">
                                          <select id="acctStatusFilter" name="acct_status">
                                             <option value="">All</option>
                                             <option value="0" {{ request()->get('acct_status', '0') == '0' ? 'selected' : '' }}>Draft</option>
                                             <option value="2" {{ request()->get('acct_status') == '2' ? 'selected' : '' }}>Approved</option>
                                             <option value="3" {{ request()->get('acct_status') == '3' ? 'selected' : '' }}>Rejected</option>
                                          </select>
                                       </form>
                                    </div>
                                 </div>
                                 <div class="card-body table-responsive">
                                    <table class="table" id="assestapprovaltable">
                                       <thead class="thead-light" style="background-color:#f1f1f1;">
                                          <tr>
                                             <th rowspan="2">EC</th>
                                             <th rowspan="2">Employee Name</th>
                                             <th rowspan="2">Type of Assets</th>
                                             <th rowspan="2">Req Date</th>
                                             <th rowspan="2">Balance Amount</th>
                                             <th rowspan="2">Requested Amount</th>
                                             <th rowspan="2">Acct. Approval Amount</th>
                                             <th colspan="3" style="text-align: center;">Approval Status</th>
                                             <th rowspan="2">Reporting Remark</th>
                                             <th rowspan="2">Approval Date</th>
                                             <th rowspan="2">Bill Copy</th>
                                             <th rowspan="2">Assets Copy</th>
                                             <th colspan="3" style="text-align:center">Detail</th>
                                             <th rowspan="2">Action</th>
                                          </tr>
                                          <tr>
                                             <th style="text-align: center;">HOD</th>
                                             <th style="text-align: center;">IT</th>
                                             <th style="text-align: center;">Account</th>
                                             <th style="text-align: center;">View</th>
                                             <th style="text-align: center;">History</th>
                                             <th style="text-align: center;">Assest Decl<sup>aration</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($assets_requestss as $index => $request)
                                          @php
                                          if ($request->HodId == $empId) {
                                          $isHODApprover = true;
                                          }
                                          if ($request->ITId == $empId) {
                                          $isITApprover = true;
                                          }
                                          if ($request->AccId == $empId) {
                                          $isAccountApprover = true;
                                          }
                                          $acctStatus = $request->AccPayStatus;
                                          $pdfPath = $request->DeclarationPdfPath;
                                          $companyID = Auth::user()->CompanyId;

                                           $pdfPath = $request->DeclarationPdfPath; // e.g., 'Employee_Assets/123/file.pdf'
                                          $pdfExists = $pdfPath && Storage::disk('s3')->exists($pdfPath);
                                          $pdfUrl = $pdfExists ? url("/file-view/{$pdfPath}") : null;
                                          @endphp
                                          <tr data-status="{{ $acctStatus }}">
                                             <td>{{ $request->EmpCode }}</td>
                                             <td>{{ $request->Fname . ' ' . $request->Sname . ' ' . $request->Lname }}</td>
                                             <td>{{ $request->AssetName}}</td>
                                             <td>{{ \Carbon\Carbon::parse($request->ReqDate)->format('d-m-Y') }}</td>
                                             <td>
                                                <b>{{ number_format((float)$request->MaxLimitAmt, 0) }}/-</b>
                                             </td>
                                             <td><b>{{ number_format($request->ReqAmt) }}/-</b></td>
                                             <td><b>{{ number_format($request->ApprovalAmt) }}/-</b></td>
                                             <td>
                                                <!-- Display the approval status for HOD without checking user role -->
                                                @if($request->HODApprovalStatus == 2)
                                                <span class="success"><b>Approved</b></span>
                                                @elseif($request->HODApprovalStatus == 0)
                                                <span class="warning"><b>Draft</b></span>
                                                @elseif($request->HODApprovalStatus == 3)
                                                <span class="danger"><b>Rejected</b></span>
                                                @else
                                                N/A
                                                @endif
                                             </td>
                                             <td>
                                                <!-- Display the approval status for IT without checking user role -->
                                                @if($request->ITApprovalStatus == 2)
                                                <span class="success"><b>Approved</b></span>
                                                @elseif($request->ITApprovalStatus == 0)
                                                <span class="warning"><b>Draft</b></span>
                                                @elseif($request->ITApprovalStatus == 3)
                                                <span class="danger"><b>Rejected</b></span>
                                                @else
                                                N/A
                                                @endif
                                             </td>
                                             <td>
                                                <!-- Display the approval status for Accounts without checking user role -->
                                                @if($request->AccPayStatus == 2)
                                                <span class="success"><b>Approved</b></span>
                                                @elseif($request->AccPayStatus == 3)
                                                <span class="danger"><b>Rejected</b></span>
                                                @elseif($request->AccPayStatus == 0)
                                                <span class="warning"><b>Draft</b></span>
                                                @else
                                                N/A
                                                @endif
                                             </td>
                                             <td>{{ $request->HODRemark }}</td>
                                             <td>{{ $request->HODSubDate ? \Carbon\Carbon::parse($request->HODSubDate)->format('d-m-Y') : '' }}
                                             </td>
                                             <td>
                                                @if($request->ReqBillImgExtName)
                                                <!-- Check if it's a PDF -->
                                                @if(str_ends_with($request->ReqBillImgExtName, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                  data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqBillImgExtName) }}"
                                                   data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
                                                  data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqBillImgExtName) }}"
                                                   data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No Bill</span>
                                                @endif
                                             </td>
                                             <td>
                                                @if($request->ReqAssestImgExtName)
                                                <!-- Check if it's a PDF -->
                                                @if(str_ends_with($request->ReqAssestImgExtName, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                   data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqAssestImgExtName) }}"
                                                   data-file-type="asset">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
                                                   data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqAssestImgExtName) }}"
                                                   data-file-type="asset">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No Asset</span>
                                                @endif
                                             </td>
                                             <td>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#viewassetsModal" onclick="viewAssetsModalFun({{ $request->AssetEmpReqId }})" class="viewassets">
                                                   <i class="fas fa-eye"></i>
                                                </a>
                                             </td>
                                             <td class="text-center">
                                                <a href="#"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#viewassetsHistoryModal"
                                                   class="viewassetsHistory"
                                                   data-employee-id="{{ $request->EmployeeID }}"
                                                   data-employee-name="{{ $request->Fname . ' ' . $request->Sname . ' ' . $request->Lname }}"
                                                   data-employee-code="{{ $request->EmpCode }}">
                                                   <i class="fas fa-history"></i>
                                                </a>

                                             </td>
                                             <td>
                                                @if ($pdfExists)
                                                   <a href="{{ $pdfUrl }}" target="_blank" class="btn btn-sm">
                                                         <i class="fas fa-file-pdf"></i>
                                                   </a>
                                                @else
                                                   <span>No PDF</span>
                                                @endif
                                             </td>   
                                                <td>
                                                <button type="button" class="mb-0 sm-btn mr-1 effect-btn btn badge-success accept-btn" data-bs-toggle="modal"
                                                   data-bs-target="#approvalModal"
                                                   data-employee-id-acct="{{ $request->AccId }}"
                                                   data-employee-id-it="{{ $request->ITId }}"
                                                   data-ApprovalAmt="{{ $request->ApprovalAmt }}"
                                                   data-employee-id-rep="{{ $request->ReportingId }}"
                                                   data-employee-id-hod="{{ $request->HodId }}"
                                                   data-request-id="{{ $request->AssetEmpReqId }}"
                                                   data-employee-id="{{ $request->EmployeeID }}"
                                                   data-employee-name="{{ $request->Fname . ' ' . $request->Sname . ' ' . $request->Lname }}"
                                                   data-asset-id="{{ $request->AssetNId }}"
                                                   data-req-amt="{{ $request->ReqAmt }}"
                                                   data-req-date="{{ $request->ReqDate }}"
                                                   data-req-amt-per-month="{{ $request->ReqAmtPerMonth }}"
                                                   data-model-name="{{ $request->ModelName }}"
                                                   data-company-name="{{ $request->ComName }}"
                                                   data-pay-amt="{{ $request->AccPayAmt }}"
                                                   data-pay-date="{{ $request->AccPayDate }}"
                                                   data-approval-status-hod="{{ $request->HODApprovalStatus }}"
                                                   data-approval-status-acct="{{ $request->AccPayStatus }}"
                                                   data-approval-status-it="{{ $request->ITApprovalStatus }}"
                                                   data-dealer-number="{{ $request->DealerContNo }}"

                                                   @if(Auth::user()->EmployeeID == $request->AccId)
                                                   @if($request->AccPayStatus == 2 || $request->AccPayStatus == 3)
                                                   disabled
                                                   @endif
                                                   @endif

                                                   @if(Auth::user()->EmployeeID == $request->ITId)
                                                   @if($request->ITApprovalStatus == 2 || $request->ITApprovalStatus == 3)
                                                   disabled
                                                   @endif
                                                   @endif

                                                   <!-- Disable button logic for HOD (HodId) -->
                                                   @if(Auth::user()->EmployeeID == $request->HodId)
                                                   @if($request->HODApprovalStatus == 2 || $request->HODApprovalStatus == 3)
                                                   disabled
                                                   @endif
                                                   @endif

                                                   <!-- Button Text Based on Approval Status for each role -->
                                                   @if(Auth::user()->EmployeeID == $request->AccId && $request->AccPayStatus == 0)
                                                   Action
                                                   @elseif(Auth::user()->EmployeeID == $request->ITId && $request->ITApprovalStatus == 0)
                                                   Action
                                                   @elseif(Auth::user()->EmployeeID == $request->HodId && $request->HODApprovalStatus == 0)
                                                   Action
                                                   @else
                                                   Actioned
                                                   @endif
                                                </button>
                                             </td>

                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>

                     <!-- all assets request details--> 
                      <div class="tab-pane fade" id="assetsallrequest" role="tabpanel"
                        aria-labelledby="assetsallrequestdetails">
                        <div class="card">
                           <div class="card-header pb-0">
                           </div>
                           <div class="card-content">
                              <div class="card-header">
                                    <div class="dflex justify-content-center align-items-center">
                                       <h4 class="has-btn">All Assets</h4>
                                      <div class="d-flex align-items-center" style="margin-left: 15px; gap: 10px;">
                                               
                                                   <select id="acctStatusAllFilter" style="width: 96px;font-size: 12px;" name="acct_status" class="form-select form-select-sm">
                                                         <option value="" {{ request()->get('acct_status', '') === '' ? 'selected' : '' }}>All</option>
                                                         <option value="0" {{ request()->get('acct_status') === '0' ? 'selected' : '' }}>Draft</option>
                                                         <option value="2" {{ request()->get('acct_status') === '2' ? 'selected' : '' }}>Approved</option>
                                                         <option value="3" {{ request()->get('acct_status') === '3' ? 'selected' : '' }}>Rejected</option>
                                                   </select>

                                             <input type="date" id="fromDate" class="form-select-sm" style="font-size: 11px;">
                                             <input type="date" id="toDate" class="form-select-sm" style="font-size: 11px;">
                                             <input type="text" id="Empcodefilter" class="form-select-sm" style="font-size: 11px;">


                                             <form method="GET" action="{{ route('asset.requests.export') }}" id="exportForm">
                                                <input type="hidden" name="acct_status" id="exportAcctStatus">
                                                <input type="hidden" name="from_date" id="exportFromDate">
                                                <input type="hidden" name="to_date" id="exportToDate">
                                                <input type="hidden" name="empcode" id="exportEmpcode">

                                                <button type="submit" style="border: none;background: none;" title="Export Excel">
                                                      <i class="fas fa-file-excel"></i>
                                                </button>
                                             </form>
                                          </div>


                                    </div>
                                 </div>
                              <div class="card-body">
                              
                              </div>
                              <div class="card chart-card">
                                    <div class="card-body table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-bordered table-striped" id="assetsTableAll">
                                       <thead class="thead-light" style="background-color:#f1f1f1;">
                                          <tr>
                                             <th rowspan="2">EC</th>
                                             <th rowspan="2">Employee Name</th>
                                             <th rowspan="2">Type of Assets</th>
                                             <th rowspan="2">Req Date</th>
                                             <th rowspan="2">Balance Amount</th>
                                             <th rowspan="2">Requested Amount</th>
                                             <th rowspan="2">Acct. Approval Amount</th>
                                             <th colspan="3" style="text-align: center;">Approval Status</th>
                                             <!-- Main Approval Status Column with Sub-columns -->
                                             <th rowspan="2">Reporting Remark</th>
                                             <th rowspan="2">Approval Date</th>
                                             <th rowspan="2">Bill Copy</th>
                                             <th rowspan="2">Assets Copy</th>
                                             <th colspan="2" style="text-align:center">Detail</th>
                                          </tr>
                                          <tr>
                                        
                                             <th style="text-align: center;">HOD</th>
                                             <th style="text-align: center;">IT</th>
                                             <th style="text-align: center;">Account</th>
                                             <th style="text-align: center;">View</th>
                                             <th style="text-align: center;">History</th>
                                            
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($assets_requestss_all as $index => $request)
                                          @php
                                          if ($request->HodId == $empId) {
                                          $isHODApprover = true;
                                          }
                                          if ($request->ITId == $empId) {
                                          $isITApprover = true;
                                          }
                                          if ($request->AccId == $empId) {
                                          $isAccountApprover = true;
                                          }
                                          $acctStatus = $request->AccPayStatus;
                                          @endphp
                                          <tr >
                                             <td class="empcodefiltertd">{{ $request->EmpCode }}</td>
                                             <td>{{ $request->Fname . ' ' . $request->Sname . ' ' . $request->Lname }}</td>
                                             <td>{{ $request->AssetName}}</td>
                                             <td class="datereq">{{ \Carbon\Carbon::parse($request->ReqDate)->format('d-m-Y') }}</td>
                                             <td>
                                                <b>{{ number_format((float)$request->MaxLimitAmt, 0) }}/-</b>
                                             </td>
                                             <td><b>{{ number_format($request->ReqAmt) }}/-</b></td>
                                             <td><b>{{ number_format($request->ApprovalAmt) }}/-</b></td>
                                             <td>
                                                <!-- Display the approval status for HOD without checking user role -->
                                                @if($request->HODApprovalStatus == 2)
                                                <span class="success"><b>Approved</b></span>
                                                @elseif($request->HODApprovalStatus == 0)
                                                <span class="warning"><b>Draft</b></span>
                                                @elseif($request->HODApprovalStatus == 3)
                                                <span class="danger"><b>Rejected</b></span>
                                                @else
                                                N/A
                                                @endif
                                             </td>
                                             <td>
                                                <!-- Display the approval status for IT without checking user role -->
                                                @if($request->ITApprovalStatus == 2)
                                                <span class="success"><b>Approved</b></span>
                                                @elseif($request->ITApprovalStatus == 0)
                                                <span class="warning"><b>Draft</b></span>
                                                @elseif($request->ITApprovalStatus == 3)
                                                <span class="danger"><b>Rejected</b></span>
                                                @else
                                                N/A
                                                @endif
                                             </td>
                                             <td>
                                                <!-- Display the approval status for Accounts without checking user role -->
                                                @if($request->AccPayStatus == 2)
                                                <span class="success acctapproved"><b>Approved</b></span>
                                                @elseif($request->AccPayStatus == 3)
                                                <span class="danger acctreject"><b>Rejected</b></span>
                                                @elseif($request->AccPayStatus == 0)
                                                <span class="warning acctdraft"><b>Draft</b></span>
                                                @else
                                                N/A
                                                @endif
                                             </td>
                                             <td>{{ $request->HODRemark }}</td>
                                             <td>{{ $request->HODSubDate ? \Carbon\Carbon::parse($request->HODSubDate)->format('d-m-Y') : '' }}
                                             </td>
                                             <td>
                                                @if($request->ReqBillImgExtName)
                                                <!-- Check if it's a PDF -->
                                                @if(str_ends_with($request->ReqBillImgExtName, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                   data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqBillImgExtName) }}"
                                                   data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
                                                   data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqBillImgExtName) }}"
                                                   data-file-type="bill">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No Bill</span>
                                                @endif
                                             </td>
                                             <td>
                                                @if($request->ReqAssestImgExtName)
                                                <!-- Check if it's a PDF -->
                                                @if(str_ends_with($request->ReqAssestImgExtName, '.pdf'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                   data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqAssestImgExtName) }}"
                                                   data-file-type="asset">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
                                                   data-file-url="{{ url('/file-view/Employee_Assets/1/' . $request->ReqAssestImgExtName) }}"
                                                   data-file-type="asset">
                                                   <i class="fas fa-eye me-2"></i>
                                                </a>
                                                @endif
                                                @else
                                                <span>No Asset</span>
                                                @endif
                                             </td>
                                             <td>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#viewassetsModal" onclick="viewAssetsModalFun({{ $request->AssetEmpReqId }})" class="viewassets">
                                                   <i class="fas fa-eye"></i>
                                                </a>
                                             </td>
                                             <td class="text-center">
                                                <a href="#"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#viewassetsHistoryModal"
                                                   class="viewassetsHistory"
                                                   data-employee-id="{{ $request->EmployeeID }}"
                                                   data-employee-name="{{ $request->Fname . ' ' . $request->Sname . ' ' . $request->Lname }}"
                                                   data-employee-code="{{ $request->EmpCode }}">
                                                   <i class="fas fa-history"></i>
                                                </a>

                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Revanue Status Start -->
            @include('employee.footerbottom')
         </div>
      </div>
   </div>
   <!-- assest view modal  -->
   <div class="modal fade show" id="assetdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
      style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalCenterTitle3">Details of Assets</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <p class="mb-2"><b>Request Date:</b> <span id="modalRequestDate"></span></p>
                     <p class="mb-2"><b>Type Of Asset:</b> <span id="modalAssetType"></span></p>
                     <p class="mb-2"><b>Balance Amount:</b> <span id="modalPrice"></span></p>
                  </div>
                  <div class="col-md-6">
                     <p class="mb-2"><b>Request Amount:</b> <span id="modalReqAmt"></span></p>
                     <p class="mb-2"><b>Approval Amount:</b> <span id="modalApprovalAmt"></span></p>
                  </div>
                  <div class="col-md-12 mb-2">
                     <p style="border:1px solid #ddd;"></p>
                  </div>
                  <!-- <div class="col-md-6">
                     <p class="mb-2"><b>Bill Copy</b></p>
                     <img style="width:250px;" id="modalBillCopy" />
                     </div>
                     <div class="col-md-6">
                     <p class="mb-2"><b>Asset Copy</b></p>
                     <img style="width:250px;" id="modalAssetCopy" />
                     </div> -->
                  <div class="col-md-12">
                     <p><b>Details:</b> <span id="modalIdentityRemark"></span></p>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                  data-bs-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!-- approval modal  -->
   <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="approvalModalLabel">Approval Status</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div id="approvalMessage" class="alert" style="display: none;"></div>
               <!-- Form to approve or reject -->
               <form action="{{ route('approve.request.team.assest') }}" method="POST" id="approvalForm">
                  @csrf
                  <input type="hidden" name="request_id" id="request_id">
                  <input type="hidden" name="employee_id" id="employee_id">
                  <div class="">
                     <label for="employee_name" class="form-label"><b>Name:</b></label>
                     <span id="employee_name_span"></span> <!-- Display the Employee Name here -->
                     <input type="hidden" class="form-control" id="employee_name" readonly> <!-- Hidden input to store value -->
                  </div>
                  <div class="row">
                     <div class="col-md-6 mb-3">
                        <label for="req_amt" class="form-label"><b>Request Amount:</b></label>
                        <span style="color:#3e757a;font-weight:600;" id="req_amt_span"></span> <!-- Display the Request Amount here -->
                        <input type="hidden" class="form-control" id="req_amt" readonly> <!-- Hidden input to store value -->
                     </div>
                     <div class="col-md-6 mb-3">
                        <label for="reg_Date" class="form-label"><b>Request Date:</b></label>
                        <span id="reg_Date_span"></span> <!-- Display the Reg Date here -->
                        <input type="hidden" class="form-control" id="reg_Date" name="reg_Date" required readonly> <!-- Hidden input to store value -->
                     </div>
                     <div class="col-md-6 mb-3 form-group s-opt">
                        <label for="approval_status" class="form-label"><b>Approval Status</b></label>
                        <select class="select2 form-control select-opt" id="approval_status" name="approval_status" required>
                           <option value="">Select Status</option>
                           <option value="2">Approved</option>
                           <option value="3">Rejected</option>
                        </select>
                        <span class="sel_arrow" style="right:25px;">
                           <i class="fa fa-angle-down"></i>
                        </span>
                        <span id="approval_status_display" style="display: none; font-weight: 600;"></span>
                     </div>
                     <div class="col-md-6 mb-3">
                        <label for="approval_date" class="form-label"><b>Approval/Paid Date</b></label>
                        <input type="date" class="form-control" id="approval_date" name="approval_date" value="" required>
                     </div>
                  </div>
                  <!-- Approval Amount field will appear conditionally -->
                  <div class="mb-3" id="approval_amount_div" style="display: none;">
                     <label for="approval_amt" class="form-label"><b>Paid Amount:</b></label>
                     <input type="number" class="form-control" id="approval_amt" name="approval_amt">
                     <span id="approval_amt_display" style="display: none; font-weight: 600;"></span>
                  </div>
                  <div class="mb-3">
                     <label for="remark" class="form-label"><b>Remark</b></label>
                     <textarea class="form-control" id="remark" name="remark" rows="3" required></textarea>
                  </div>
                  <input type="hidden" id="employeeId" name="employeeId">
                  <input type="hidden" id="assestsid" name="assestsid">
                  <button type="submit" class="btn btn-primary" id="submit_button">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal for Editing -->
   <!-- Modal for Editing -->
   <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="editModalLabel">Edit Vehicle Request</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="editForm" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="request_id" id="modal_request_id">

                  <!-- Employee ID -->
                  <!-- <div class="mb-3">
                     <label for="modal_employee_id" class="form-label">Employee ID</label>
                     <input type="text" class="form-control" id="modal_employee_id" name="employee_id" readonly>
                  </div> -->

                  <!-- Employee Code -->
                  <!-- <div class="mb-3">
                     <label for="modal_emp_code" class="form-label">Employee Code</label>
                     <input type="text" class="form-control" id="modal_emp_code" name="emp_code" readonly>
                  </div> -->

                  <!-- Vehicle Brand -->
                  <div class="row">
                     <!-- Vehicle Brand -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_vehicle_brand" class="form-label"><strong>Vehicle Brand</strong></label>
                        <input type="text" class="form-control" id="modal_vehicle_brand" name="vehicle_brand" placeholder="Enter vehicle brand">
                     </div>

                     <!-- Model Name -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_model_name" class="form-label"><strong>Model Name</strong></label>
                        <input type="text" class="form-control" id="modal_model_name" name="model_name" placeholder="Enter model name">
                     </div>

                     <!-- Model Number -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_model_no" class="form-label"><strong>Model Number</strong></label>
                        <input type="text" class="form-control" id="modal_model_no" name="model_no" placeholder="Enter model number">
                     </div>

                     <!-- Dealer Name -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_dealer_name" class="form-label"><strong>Dealer Name</strong></label>
                        <input type="text" class="form-control" id="modal_dealer_name" name="dealer_name" placeholder="Enter dealer name">
                     </div>

                     <!-- Dealer Contact -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_dealer_contact" class="form-label"><strong>Dealer Contact</strong></label>
                        <input type="text" class="form-control" id="modal_dealer_contact" name="dealer_contact" pattern="^\d{10}$|^\d{12}$" placeholder="Enter dealer contact number">
                     </div>

                     <!-- Purchase Date -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_purchase_date" class="form-label"><strong>Purchase Date</strong></label>
                        <input type="date" class="form-control" id="modal_purchase_date" name="purchase_date" placeholder="Select purchase date">
                     </div>

                     <!-- Price -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_price" class="form-label"><strong>Price</strong></label>
                        <input type="number" class="form-control" id="modal_price" name="price" placeholder="Enter price">
                     </div>

                     <!-- Registration Number -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_registration_no" class="form-label"><strong>Registration Number</strong></label>
                        <input type="text" class="form-control" id="modal_registration_no" name="registration_number" placeholder="Enter registration number">
                     </div>

                     <!-- Registration Date -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_registration_date" class="form-label"><strong>Registration Date</strong></label>
                        <input type="date" class="form-control" id="modal_registration_date" name="registration_date" placeholder="Select registration date">
                     </div>

                     <!-- Bill Number -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_bill_no" class="form-label"><strong>Bill Number</strong></label>
                        <input type="text" class="form-control" id="modal_bill_no" name="bill_number" placeholder="Enter bill number">
                     </div>

                     <!-- Fuel Type -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_fuel_type" class="form-label"><strong>Fuel Type</strong></label>
                        <select class="form-control" id="modal_fuel_type" name="fuel_type">
                           <option value="" disabled selected>Select fuel type</option>
                           <option value="petrol">Petrol</option>
                           <option value="diesel">Diesel</option>
                           <option value="electric">Electric</option>
                           <option value="cng">CNG</option>
                        </select>
                     </div>

                     <!-- Ownership -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_ownership" class="form-label"><strong>Ownership</strong></label>
                        <select class="form-control" id="modal_ownership" name="ownership">
                           <option value="" disabled selected>Select ownership</option>
                           <option value="1">1st</option>
                           <option value="2">2nd</option>
                           <option value="3">3rd</option>
                        </select>
                     </div>

                     <!-- Vehicle Image -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_vehicle_image" class="form-label"><strong>Vehicle Image</strong></label>
                        <input type="file" class="form-control" id="modal_vehicle_image" name="vehicle_image">
                     </div>

                     <!-- RC File -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_rc_file" class="form-label"><strong>RC Copy</strong></label>
                        <input type="file" class="form-control" id="modal_rc_file" name="rc_file">
                     </div>

                     <!-- Insurance -->
                     <div class="mb-3 col-md-4">
                        <label for="modal_insurance" class="form-label"><strong>Insurance Copy</strong></label>
                        <input type="file" class="form-control" id="modal_insurance" name="insurance">
                     </div>

                     <!-- Current Odometer -->
                     <!-- <div class="mb-3">
                     <label for="modal_current_odo_meter" class="form-label">Current Odometer</label>
                     <input type="number" class="form-control" id="modal_current_odo_meter" name="current_odo_meter">
                  </div> -->

                     <!-- Four Vehicle Fields (For 4-Wheeler) -->
                     <div id="four-wheeler-fields" style="display: none;">
                        <!-- Four Vehicle Brand -->
                        <div class="row">
                           <!-- Brand -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_brand" class="form-label"><strong>Brand</strong></label>
                              <input type="text" class="form-control" id="modal_four_brand" name="four_brand" placeholder="Enter brand">
                           </div>

                           <!-- Model Name -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_model_name" class="form-label"><strong>Model Name</strong></label>
                              <input type="text" class="form-control" id="modal_four_model_name" name="four_model_name" placeholder="Enter model name">
                           </div>

                           <!-- Model Number -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_model_no" class="form-label"><strong>Model Number</strong></label>
                              <input type="text" class="form-control" id="modal_four_model_no" name="four_model_no" placeholder="Enter model number">
                           </div>

                           <!-- Dealer Name -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_dealer_name" class="form-label"><strong>Dealer Name</strong></label>
                              <input type="text" class="form-control" id="modal_four_dealer_name" name="four_dealer_name" placeholder="Enter dealer name">
                           </div>

                           <!-- Dealer Contact -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_dealer_contact" class="form-label"><strong>Dealer Contact</strong></label>
                              <input type="text" class="form-control" id="modal_four_dealer_contact" name="four_dealer_contact" pattern="^\d{10}$|^\d{12}$" placeholder="Enter dealer contact number">
                           </div>

                           <!-- Purchase Date -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_purchase_date" class="form-label"><strong>Purchase Date</strong></label>
                              <input type="date" class="form-control" id="modal_four_purchase_date" name="four_purchase_date" placeholder="Select purchase date">
                           </div>

                           <!-- Price -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_price" class="form-label"><strong>Price</strong></label>
                              <input type="number" class="form-control" id="modal_four_price" name="four_price" placeholder="Enter price">
                           </div>

                           <!-- Registration Number -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_registration_no" class="form-label"><strong>Registration No</strong></label>
                              <input type="text" class="form-control" id="modal_four_registration_no" name="four_registration_number" placeholder="Enter registration number">
                           </div>

                           <!-- Registration Date -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_registration_date" class="form-label"><strong>Registration Date</strong></label>
                              <input type="date" class="form-control" id="modal_four_registration_date" name="four_registration_date" placeholder="Select registration date">
                           </div>

                           <!-- Bill Number -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_bill_no" class="form-label"><strong>Bill Number</strong></label>
                              <input type="text" class="form-control" id="modal_four_bill_no" name="four_bill_number" placeholder="Enter bill number">
                           </div>

                           <!-- Fuel Type -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_fuel_type" class="form-label"><strong>Fuel Type</strong></label>
                              <select class="form-control" id="modal_four_fuel_type" name="four_fuel_type">
                                 <option value="" disabled selected>Select fuel type</option>
                                 <option value="petrol">Petrol</option>
                                 <option value="diesel">Diesel</option>
                                 <option value="electric">Electric</option>
                              </select>
                           </div>

                           <!-- Ownership -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_ownership" class="form-label"><strong>Ownership</strong></label>
                              <select class="form-control" id="modal_four_ownership" name="four_ownership">
                                 <option value="" disabled selected>Select ownership</option>
                                 <option value="1">1st</option>
                                 <option value="2">2nd</option>
                                 <option value="3">3rd</option>
                              </select>
                           </div>

                           <!-- Vehicle Image -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_vehicle_image" class="form-label"><strong>Vehicle Image</strong></label>
                              <input type="file" class="form-control" id="modal_four_vehicle_image" name="four_vehicle_image">
                           </div>

                           <!-- RC File -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_rc_file" class="form-label"><strong>RC Copy</strong></label>
                              <input type="file" class="form-control" id="modal_four_rc_file" name="four_rc_file">
                           </div>

                           <!-- Insurance -->
                           <div class="mb-3 col-md-4">
                              <label for="modal_four_insurance" class="form-label"><strong>Insurance Copy</strong></label>
                              <input type="file" class="form-control" id="modal_four_insurance" name="four_insurance">
                           </div>

                           <!-- Current Odometer -->
                           <!-- <div class="mb-3">
                           <label for="modal_four_current_odo_meter" class="form-label">Four Current Odometer</label>
                           <input type="number" class="form-control" id="modal_four_current_odo_meter" name="four_current_odo_meter">
                        </div> -->

                           <!-- Four Odometer -->
                           <!-- <div class="mb-3">
                           <label for="modal_four_odo_meter" class="form-label">Four Odometer</label>
                           <input type="number" class="form-control" id="modal_four_odo_meter" name="four_odo_meter">
                        </div> -->
                        </div>
                     </div>
                     <!-- Remark -->
                     <div class="mb-3">
                        <label for="modal_remark" class="form-label">Remarks</label>
                        <textarea class="form-control" id="modal_remark" name="remark"></textarea>
                     </div>
                     <!-- Form Actions -->
                     <div class="text-end">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
   <div class="modal fade" id="fileModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="fileModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               <h5 class="modal-title" id="fileModalLabel">File Preview</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <!-- Dynamically load the content here -->
               <div id="filePreviewContainer">
                  <!-- File content will be dynamically loaded here (image or other file type) -->
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" id="printFilePreviewBtn">Print</button>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal for PDF preview with pagination -->
   <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">
               <!-- PDF carousel -->
               <div id="pdfCarousel" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner" id="pdfCarouselContent"></div>
                  <!-- Custom Previous Button -->
                  <button class="carousel-control-prev" type="button" data-bs-target="#pdfCarousel"
                     data-bs-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Previous</span>
                  </button>
                  <!-- Custom Next Button -->
                  <button class="carousel-control-next" type="button" data-bs-target="#pdfCarousel"
                     data-bs-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Next</span>
                  </button>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" id="printPdfPreviewBtn">Print PDF</button>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal official assets details -->
   <div id="viewOfficialAssetsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewOfficialAssetsModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="viewqueryModalLabel">Official Assets Details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row assets-details-popup">
                  <!----------- Official Assets -------------->
                  <div class="col-md-6 mb-2">
                     <b>Type of Asset:</b>
                     <span>-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Assest ID:</b>
                     <span>-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Company:</b>
                     <span>HP</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Model Name:</b>
                     <span>-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Serial Number:</b>
                     <span>-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Allocated:</b>
                     <span>-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Returned:</b>
                     <span>-</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal assets details -->
   <div id="viewassetsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewassetsModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="viewqueryModalLabel">Assets Details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row assets-details-popup">
                  <div class="float-start w-100 pb-1 mb-2" style="border-bottom:1px solid #ddd;">
                     <h6 class="float-start"><b>Asset Name: <span id="asstAssetName">-</span></b></h6>
                  </div>
                  <div class="float-start w-100 pb-1 mb-2" style="border-bottom:1px solid #ddd;display: none">
                     <h6 class="float-start"><b>Vehicle Type: <span id="asstVehicleType">-</span></b></h6>
                  </div>
                  <div class="col-md-6 mb-2" id="asstLimitFeild" style="display: none">
                     <b>Limit:</b>
                     <span id="asstLimit">-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Model Name:</b>
                     <span id="asstModelName">-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Model Number:</b>
                     <span id="asstModelNumber">-</span>
                  </div>
                  <div class="col-md-6 mb-2" id="asstVehicleBrandFeild" style="display: none">
                     <b>Vehicle Brand:</b>
                     <span id="asstVehicleBrand">-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Company Name:</b>
                     <span id="asstCompanyName">-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Purchase Date:</b>
                     <span id="asstPurchaseDate">-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Dealer Name:</b>
                     <span id="asstDealerName">-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Dealer Contact:</b>
                     <span id="asstDealerContact">-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Price:</b>
                     <span id="asstPrice">2540/-</span>
                  </div>
                  <div class="col-md-6 mb-2">
                     <b>Bill Number:</b>
                     <span id="asstBillNumber">-</span>
                  </div>
                  <div class="col-md-6 mb-2" id="asstRequestAmountFeild" style="display: none">
                     <b>Request Amount:</b>
                     <span id="asstRequestAmount">-</span>
                  </div>
                  <div class="col-md-6 mb-2" id="asstIMEINoFeild" style="display: none">
                     <b>IMEI No.:</b>
                     <span id="asstIMEINo">-</span>
                  </div>
                  <div class="col-md-6 mb-2" id="asstFuelTypeFeild" style="display: none">
                     <b>Fuel Type:</b>
                     <span id="asstFuelType">-</span>
                  </div>
                  <div class="col-md-6 mb-2" id="asstRegistrationNumberFeild" style="display: none">
                     <b>Registration Number:</b>
                     <span id="asstRegistrationNumber">-</span>
                  </div>
                  <div class="col-md-6 mb-2" id="asstRegistrationNumberFeild" style="display: none">
                     <b>Registration Date:</b>
                     <span id="asstRegistrationDate">-</span>
                  </div>
                  <div class="col-md-6 mb-2" id="asstOwnershipFeild" style="display: none">
                     <b>Ownership:</b>
                     <span id="asstOwnership">-</span>
                  </div>
                  <div class="col-md-12 mb-2">
                     <p style="border:1px solid #ddd;"></p>
                  </div>
                  <div class="col-md-6 bill-show mb-2">
                     <ul class="p-0 ml-3">
                        <li><b>Bill Copy</b><a href="#" id="asstBillCopy" target="_blank" aria-label="Download Bill Copy"><i class="fas fa-file-pdf"></i></a></li>
                        <li id="asstBillCopyFeild" style="display: none"><b>DL Copy</b><a id="asstDLCopy" href="#" aria-label="Download DL Copy"><i class="fas fa-file-image"></i></a></li>
                        <li id="asstVehiclePhotoFeild" style="display: none"><b>Vehicle Photo</b><a id="asstVehiclePhoto" href="#" aria-label="Download Vehicle Photo"><i class="fas fa-file-image"></i></a></li>
                        <li id="asstOdometerReadingFeild" style="display: none"><b>1st Odometer Reading image</b><a href="#" id="asstOdometerReading" aria-label="Download Insurance 1st Odometer Reading image"><i class="fas fa-file-image"></i></a></li>
                     </ul>
                  </div>
                  <div class="col-md-6 bill-show mb-2">
                     <ul class="p-0 ml-3">
                        <li id="asstAssetsCopyFeild" style="display: none"><b>Assets Copy</b><a href="#" id="asstAssetsCopy" target="_blank" aria-label="Download Assets Copy"><i class="fas fa-file-image"></i></a></li>
                        <li id="asstRCCopyFeild" style="display: none"><b>RC Copy</b><a href="#" id="asstRCCopy" aria-label="Download RC Copy"><i class="fas fa-file-image"></i></a></li>
                        <li id="asstInsuranceCopyFeild" style="display: none"><b>Insurance Copy</b><a href="#" id="asstInsuranceCopy" aria-label="Download Insurance Copy"><i class="fas fa-file-pdf"></i></a></li>
                     </ul>
                  </div>
                  <div class="col-md-12">
                     <b>Remarks:</b>
                     <span id="asstRemark">-</span>
                  </div>
                  <div class="col-md-12" id="HODFeild" style="display: none">
                     <div class="query-req-section">
                        <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                           <span class="float-start"><b>HOD</b></span>
                           <span class="float-end"><b>Status: <span id="HODApprovalStatus">Pending</span></b></span>
                        </div>
                        <div class="mb-2">
                           <p>Remarks: <span id="HODApprovalRemarks">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</span></p>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b>Date</b> <span id="HODApprovalDate">15 May 2024</span></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12" id="ITFeild" style="display: none">
                     <div class="query-req-section">
                        <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                           <span class="float-start"><b>IT</b></span>
                           <span class="float-end"><b>Status: <span id="ITApprovalStatus" class="text-success">Pending</span></b></span>
                        </div>
                        <div class="mb-2">
                           <p>Remarks: <span id="ITApprovalRemarks">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</span></p>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b>Date:</b> <span id="ITApprovalDate">15 May 2024</span></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12" id="AccPayFeild" style="display: none">
                     <div class="query-req-section">
                        <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                           <span class="float-start"><b>Account</b></span>
                           <span class="float-end"><b>Status: <span class="text-success" id="AccPayStatus">Pending</span></b></span>
                        </div>
                        <div class="mb-2">
                           <p>Remarks: <span id="AccPayRemarks">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</span></p>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b>Date</b> <span id="AccPayDate">15 May 2024</span></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal assets history details -->
   <div id="viewassetsHistoryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewassetsHistoryModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="viewqueryModalLabel">Assets History Details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row assets-request-box">
                  <h5>Assets Request History Details</h5>

                  <div class="col-md-6">
                     <div class="assets-req-section">
                        <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                           <span class="float-start"><b>Name of assets.: Mobile Phone</b></span>
                           <span class="float-end"><b>Status:</b> <b class="success">Approved</b></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start">Request Amount: <b>1200/-</b></span>
                           <span class="float-end">Balance Amount: <b>1200/-</b></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start">Company: HP</span>
                           <span class="float-end">Dealer: Flipcart</span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start">Model: </span>
                           <span class="float-end">Price: <b>1200/-</b></span>
                        </div>
                        <div class="mb-2">
                           <p>Remarks: "Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b>Request date:</b> 15 May 2024</span>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b>Copy:</b> <a class="ms-2 link" href="">Bill</a><a class="ms-3 link" href="">Assets</a></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="assets-req-section">
                        <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                           <span class="float-start"><b>Name of assets.: Mobile Phone</b></span>
                           <span class="float-end"><b>Status:</b> <b class="success">Approved</b></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start">Request Amount: <b>1200/-</b></span>
                           <span class="float-end">Balance Amount: <b>1200/-</b></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start">Company: HP</span>
                           <span class="float-end">Dealer: Flipcart</span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start">Model: </span>
                           <span class="float-end">Price: <b>1200/-</b></span>
                        </div>
                        <div class="mb-2">
                           <p>Remarks: "Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b>Request date:</b> 15 May 2024</span>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b>Copy:</b> <a class="ms-2 link" href="">Bill</a><a class="ms-3 link" href="">Assets</a></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('employee.footer')
   <script>
      const employeeId = {{ Auth::user()->EmployeeID}};
      const asseststoreUrl = "{{ route('asset.request.store')  }}";

      // Handle form submission with AJAX
      $('#assetRequestFormVehcile').on('submit', function(e) {
         e.preventDefault(); // Prevent the default form submission
         $('#loader').show();

         var formData = new FormData(this); // FormData object to handle file uploads

         // Disable the submit button to prevent multiple submissions
         $('#submitBtn').prop('disabled', true).text('Submitting...');

         $.ajax({
            url: '{{ route('submit.vehicle.request')}}', // URL for the form submission route
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
               $('#loader').hide();

               // Enable the submit button after the form is successfully submitted
               $('#submitBtn').prop('disabled', false).text('Submit');
               // Display success toast
               toastr.success(response.message, 'Success', {
                  "positionClass": "toast-top-right", // Position it at the top right of the screen
                  "timeOut": 5000 // Duration for which the toast is visible (in ms)
               });
               setTimeout(function() {
                  location.reload(); // Optionally, reload the page
               }, 3000); // Delay before reset and reload to match the toast timeout

            },
            error: function(xhr, status, error) {
               // Enable the submit button after an error occurs
               $('#submitBtn').prop('disabled', false).text('Submit');

               // Show an error message in the toaster
               if (xhr.responseJSON && xhr.responseJSON.message) {
                  toastr.error(xhr.responseJSON.message, 'Error');
               } else {
                  toastr.error('An error occurred while submitting the form.', 'Error');
               }
               $('#loader').hide();

            }
         });
      });

      function toggleApprovalView(requestId) {
         var approvalRow = document.getElementById('approval-row-' + requestId);

         // Toggle visibility of the approval section row
         if (approvalRow.style.display === "none") {
            approvalRow.style.display = "table-row"; // Show the approval details row
         } else {
            approvalRow.style.display = "none"; // Hide the approval details row
         }
      }
      $(document).ready(function() {
         // When the edit button is clicked
         $('.edit-btn').on('click', function() {
            // Get data from the clicked button using data-* attributes
            const requestId = $(this).data('id');
            const employeeId = $(this).data('employee-id');
            const empCode = $(this).data('emp-code');
            const brand = $(this).data('brand');
            const modelName = $(this).data('model-name');
            const modelNo = $(this).data('model-no');
            const dealerName = $(this).data('dealer-name');
            const wheelertype = $(this).data('wheeler');
            const dealerContact = $(this).data('dealer-contact');
            const purchaseDate = $(this).data('purchase-date');
            const price = $(this).data('price');
            const registrationNo = $(this).data('registration-no');
            const registrationDate = $(this).data('registration-date');
            const billNo = $(this).data('bill-no');
            const invoice = $(this).data('invoice');
            const fuelType = $(this).data('fuel-type');
            const ownership = $(this).data('ownership');
            const vehicleImage = $(this).data('vehicle-image');
            const rcFile = $(this).data('rc-file');
            const insurance = $(this).data('insurance');
            const currentOdoMeter = $(this).data('current-odo-meter');
            const odoMeter = $(this).data('odo-meter');
            const fourBrand = $(this).data('four-brand');
            const fourModelName = $(this).data('four-model-name');
            const fourModelNo = $(this).data('four-model-no');
            const fourDealerName = $(this).data('four-dealer-name');
            const fourDealerContact = $(this).data('four-dealer-contact');
            const fourPurchaseDate = $(this).data('four-purchase-date');
            const fourPrice = $(this).data('four-price');
            const fourRegistrationNo = $(this).data('four-registration-no');
            const fourRegistrationDate = $(this).data('four-registration-date');
            const fourBillNo = $(this).data('four-bill-no');
            const fourInvoice = $(this).data('four-invoice');
            const fourFuelType = $(this).data('four-fuel-type');
            const fourOwnership = $(this).data('four-ownership');
            const fourVehicleImage = $(this).data('four-vehicle-image');
            const fourRcFile = $(this).data('four-rc-file');
            const fourInsurance = $(this).data('four-insurance');
            const fourCurrentOdoMeter = $(this).data('four-current-odo-meter');
            const fourOdoMeter = $(this).data('four-odo-meter');
            const remark = $(this).data('remark');
            const createdBy = $(this).data('created-by');
            const createdDate = $(this).data('created-date');
            const yearId = $(this).data('year-id');
            const createdAt = $(this).data('created-at');
            const updatedAt = $(this).data('updated-at');
            console.log(wheelertype);
            // Populate the modal fields with the data
            $('#modal_request_id').val(requestId);
            $('#modal_vehicle_brand').val(brand);
            $('#modal_model_name').val(modelName);
            $('#modal_model_no').val(modelNo);
            $('#modal_dealer_name').val(dealerName);
            $('#modal_dealer_contact').val(dealerContact);
            $('#modal_purchase_date').val(purchaseDate);
            $('#modal_price').val(price);
            $('#modal_registration_no').val(registrationNo);
            $('#modal_registration_date').val(registrationDate);
            $('#modal_bill_no').val(billNo);
            //   $('#modal_invoice').val(invoice);
            $('#modal_fuel_type').val(fuelType);
            $('#modal_ownership').val(ownership);
            $('#modal_vehicle_image').val('');
            $('#modal_rc_file').val('');
            $('#modal_insurance').val('');
            //   $('#modal_current_odo_meter').val('');
            //   $('#modal_odo_meter').val(odoMeter);
            $('#modal_four_brand').val(fourBrand);
            $('#modal_four_model_name').val(fourModelName);
            $('#modal_four_model_no').val(fourModelNo);
            $('#modal_four_dealer_name').val(fourDealerName);
            $('#modal_four_dealer_contact').val(fourDealerContact);
            $('#modal_four_purchase_date').val(fourPurchaseDate);
            $('#modal_four_price').val(fourPrice);
            $('#modal_four_registration_no').val(fourRegistrationNo);
            $('#modal_four_registration_date').val(fourRegistrationDate);
            $('#modal_four_bill_no').val(fourBillNo);
            //   $('#modal_four_invoice').val(fourInvoice);
            $('#modal_four_fuel_type').val(fourFuelType);
            $('#modal_four_ownership').val(fourOwnership);
            $('#modal_four_vehicle_image').val('');
            $('#modal_four_rc_file').val('');
            $('#modal_four_insurance').val('');
            //   $('#modal_four_current_odo_meter').val('');
            //   $('#modal_four_odo_meter').val(fourOdoMeter);
            $('#modal_remark').val(remark);

            if (wheelertype == '2-wheeler') {
               // Show 2-wheeler fields and hide 4-wheeler fields
               $('#modal_vehicle_brand, #modal_model_name, #modal_model_no, #modal_dealer_name, #modal_dealer_contact, #modal_purchase_date, #modal_price, #modal_registration_no, #modal_registration_date, #modal_bill_no, #modal_fuel_type, #modal_ownership, #modal_vehicle_image, #modal_rc_file, #modal_insurance').closest('.mb-3').show();

               // Hide 4-wheeler fields
               $('#four-wheeler-fields').hide();
            } else if (wheelertype == '4-wheeler') {
               // Show 4-wheeler fields and hide 2-wheeler fields
               $('#four-wheeler-fields').show();

               // Hide 2-wheeler fields
               $('#modal_vehicle_brand, #modal_model_name, #modal_model_no, #modal_dealer_name, #modal_dealer_contact, #modal_purchase_date, #modal_price, #modal_registration_no, #modal_registration_date, #modal_bill_no, #modal_fuel_type, #modal_ownership, #modal_vehicle_image, #modal_rc_file, #modal_insurance').closest('.mb-3').hide();
            }


            // Open the modal
            $('#editModal').modal('show');
         });

         // Handle form submission with AJAX
         $('#editForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            $('#loader').show();

            var formData = new FormData(this); // Get form data, including files

            // Send data via AJAX
            $.ajax({
               url: '/update-vehicle', // Your update route here
               type: 'POST',
               data: formData,
               processData: false, // Do not process the data
               contentType: false, // Do not set content type
               success: function(response) {
                  if (response.success) {
                     // Show a success toast notification with custom settings
                     toastr.success(response.message, 'Success', {
                        "positionClass": "toast-top-right", // Position the toast at the top-right corner
                        "timeOut": 3000 // Duration for which the toast will be visible (3 seconds)
                     });
                     $('#loader').hide();

                     // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                     setTimeout(function() {
                        location.reload(); // Optionally, reload the page
                     }, 3000); // Delay before reset and reload to match the toast timeout

                  } else {
                     // Show an error toast notification with custom settings
                     $('#loader').hide();

                  }
               },
               error: function(xhr, status, error) {
                  // Handle error
                  toastr.error('An error occurred. Please try again.', 'Error', {
                     "positionClass": "toast-top-right", // Position the toast at the top-right corner
                     "timeOut": 3000 // Duration for which the toast will be visible (3 seconds)
                  });

                  // Re-enable submit button
                  $('.btn-success').prop('disabled', false).text('Submit');
               }
            });
         });
      });


      // Handle form submission with AJAX
      document.getElementById('approvalForm').addEventListener('submit', function(event) {
         event.preventDefault(); // Prevent default form submission
         $('#loader').show();

         var form = new FormData(this); // Collect form data
         var url = '{{ route('approve.request')}}'; // The route to send the request

         fetch(url, {
               method: 'POST',
               body: form,
            })
            .then(response => response.json()) // Parse the JSON response
            .then(response => {
               // Handle success
               if (response.success) {
                  $('#loader').hide();

                  // Show a success toast notification with custom settings
                  toastr.success(response.message, 'Success', {
                     "positionClass": "toast-top-right", // Position the toast at the top-right corner
                     "timeOut": 3000 // Duration for which the toast will be visible (3 seconds)
                  });

                  // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                  setTimeout(function() {
                     $('#approvalForm')[0].reset(); // Reset the form
                     location.reload(); // Optionally, reload the page
                  }, 3000); // Delay before reset and reload to match the toast timeout

               } else {
                  // Show an error toast notification with custom settings
                  toastr.error('Error: ' + response.message, 'Error', {
                     "positionClass": "toast-top-right", // Position the toast at the top-right corner
                     "timeOut": 3000 // Duration for which the toast will be visible (3 seconds)
                  });
                  $('#loader').hide();

               }

               // Re-enable submit button
               $('.btn-success').prop('disabled', false).text('Submit');
            })
            .catch(error => {
               // Handle error
               toastr.error('An error occurred. Please try again.', 'Error', {
                  "positionClass": "toast-top-right", // Position the toast at the top-right corner
                  "timeOut": 3000 // Duration for which the toast will be visible (3 seconds)
               });

               $('#loader').hide();

               // Re-enable submit button
               $('.btn-success').prop('disabled', false).text('Submit');
            });
      });

      $('#approvalModal').on('show.bs.modal', function(event) {

         function formatDateddmmyyyy(date) {
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0'); // Ensures two digits for day
            const month = String(d.getMonth() + 1).padStart(2, '0'); // Ensures two digits for month
            const year = d.getFullYear();
            return `${day}-${month}-${year}`; // Format as dd-mm-yyyy
         }
         var button = $(event.relatedTarget); // Button that triggered the modal
         var today = new Date();
         var dd = String(today.getDate()).padStart(2, '0');
         var mm = String(today.getMonth() + 1).padStart(2, '0');
         var yyyy = today.getFullYear();
         today = yyyy + '-' + mm + '-' + dd;

         // Extract data attributes from the button
         var requestId = button.data('request-id');
         var emplyeeid = button.data('employee-id');

         var employeeName = button.data('employee-name');
         var reqAmt = button.data('req-amt');
         var reqDate = button.data('req-date');
         var approvalStatusHOD = button.data('approval-status-hod');
         var approvalStatusIT = button.data('approval-status-it');
         var approvalStatusAcct = button.data('approval-status-acct');
         var approvalStatusRep = button.data('approval-status-hod');
         var employeeIdHOD = button.data('employee-id-hod');
         var employeeIdIT = button.data('employee-id-it');
         var employeeIdAcct = button.data('employee-id-acct');
         var employeeIdRep = button.data('employee-id-rep');
         var acctamountapproval = button.data('approvalamt');
         console.log(acctamountapproval);

         var reqspan = formatDateddmmyyyy(reqDate);
         console.log(reqspan);

         // Populate modal fields
         $('#request_id').val(requestId);
         $('#employee_id').val(emplyeeid);
         $('#employee_name').val(employeeName);
         $('#employee_name_span').text(employeeName);
         $('#req_amt').val(reqAmt);
         $('#req_amt_span').text(reqAmt);
         $('#reg_Date').val(reqspan);
         $('#approval_date').val();
         $('#reg_Date_span').text(reqspan);
         $('#acctamountapproval').text(acctamountapproval);
         console.log(acctamountapproval);

         // Employee ID from auth
         var EmployeeID = {{Auth::user()->EmployeeID}};
         if (EmployeeID == employeeIdAcct) {
            $('#approval_amount_div').show(); // Set the hidden input value

         } else {
            $('#approval_amount_div').hide(); // Set the hidden input value

         }
         // Function to handle status display for specific roles
         function displayApprovalStatus(employeeRoleId, approvalStatus) {
            if (EmployeeID == employeeRoleId && approvalStatus == 2) {
               var statusText = approvalStatus == 2 ? "Approved" : approvalStatus == 3 ? "Rejected" : "Pending";
               $('#approval_status').hide(); // Hide the dropdown
               $('#approval_amt').hide(); // Hide the dropdown
               $('#approval_status').prop('required', false); // Remove required attribute
               $('#approval_status_hidden').val(approvalStatus); // Set the hidden input value

               $('#approval_status_display').text(`${statusText}`).show(); // Display status text
               $('#approval_amt_display').text(`${acctamountapproval}`).show(); // Display status text

               $('.sel_arrow').hide();
               $('#submit_button').hide();


            } else {
               // Show the dropdown and the arrow if no role-specific status applies
               $('#approval_status').show();
               $('#approval_status').prop('required', true);
               $('#approval_status_display').hide();
               $('.sel_arrow').show();
               $('#submit_button').show();

            }
         }


         // Logic for roles
         displayApprovalStatus(employeeIdHOD, approvalStatusHOD);
         displayApprovalStatus(employeeIdIT, approvalStatusIT);
         displayApprovalStatus(employeeIdAcct, approvalStatusAcct);
         displayApprovalStatus(employeeIdRep, approvalStatusRep);
      });

      $(document).ready(function() {
         // Handle form submission with AJAX
         $('#assetRequestForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission
            $('#assetRequestForm button[type="submit"]').prop('disabled', true);

            $('#loader').show();

            // Prepare form data (including files)
            // Prepare form data (including files)
            var formData = new FormData(this);
            formData.append('assetRequestForm', $(this).attr('id'));

            // Loop through all the form data entries
            for (var pair of formData.entries()) {
               // Check if the value is a File object (to exclude files from logging)
               if (pair[1] instanceof File) {
                  // Skip file fields
                  continue;
               }

               // Check if the 'maximum_limit' field is in the form data and the parent div is hidden
               if (pair[0] === 'maximum_limit') {
                  // Check if the parent div of 'maximum_limit' (which is '#max_limit') is hidden
                  if ($('#max_limit').is(':hidden')) {
                     // Skip adding the 'maximum_limit' field to the FormData
                     formData.delete(pair[0]); // Delete it from formData
                     continue;

                  }
               }

               // Log only the non-file data (text inputs, etc.)
               console.log(pair[0] + ': ' + pair[1]);
            }

            // Make AJAX request to submit the form
            $.ajax({
               url: asseststoreUrl, // Your Laravel route to handle the form submission
               type: 'POST',
               data: formData,
               processData: false, // Don't process the data
               contentType: false, // Don't set content type header
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is passed
               },
               success: function(response) {
                  // Handle success
                  if (response.success) {
                     $('#loader').hide();
                     $('#assetRequestForm button[type="submit"]').prop('disabled', false);

                     // Show a success toast notification with custom settings
                     toastr.success(response.message, 'Success', {
                        "positionClass": "toast-top-right", // Position the toast at the top-right corner
                        "timeOut": 3000 // Duration for which the toast will be visible (3 seconds)
                     });

                     // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                     setTimeout(function() {
                        $('#assetRequestForm')[0].reset(); // Reset the form
                        location.reload(); // Optionally, reload the page
                     }, 3000); // Delay before reset and reload to match the toast timeout

                  } else {
                     // Show an error toast notification with custom settings
                     toastr.error('Error: ' + response.message, 'Error', {
                        "positionClass": "toast-top-right", // Position the toast at the top-right corner
                        "timeOut": 3000 // Duration for which the toast will be visible (3 seconds)
                     });
                     $('#loader').hide();
                     $('#assetRequestForm button[type="submit"]').prop('disabled', false);


                  }

               },
               error: function(xhr, status, error) {
                  // Handle error
                  toastr.error('An error occurred. Please try again.', 'Error', {
                     "positionClass": "toast-top-right", // Position the toast at the top-right corner
                     "timeOut": 3000 // Duration for which the toast will be visible (3 seconds)
                  });
                  $('#loader').hide();


                  // Re-enable submit button
                  $('#assetRequestForm button[type="submit"]').prop('disabled', false);
               }

            });
         });
      });



      $(document).ready(function() {
         var table = $('#assestapprovaltable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "pageLength": 10,
            "lengthMenu": [10, 25, 50, 100],
         });

         var approverColumn = 9;

         if ({!!json_encode($isHODApprover) !!}) {
            approverColumn = 7;
         } else if ({!!json_encode($isITApprover) !!}) {
            approverColumn = 8;
         }


         var defaultFilter = 'Draft';
         table.column(approverColumn).search(defaultFilter).draw();


         $('#acctStatusFilter').on('change', function() {
            var filterValue = $(this).val();
            var statusText = '';

            if (filterValue === '0') {
               statusText = 'Draft';
            } else if (filterValue === '2') {
               statusText = 'Approved';
            } else if (filterValue === '3') {
               statusText = 'Rejected';
            }


            table.column(approverColumn).search(statusText).draw();
         });

         var approverColumn = 9;

         if ({!!json_encode($isHODApprover) !!}) {
            approverColumn = 7;
         } else if ({!!json_encode($isITApprover) !!}) {
            approverColumn = 8;
         }


         var defaultFilter = '';
         table.column(approverColumn).search(defaultFilter).draw();


      });
      document.addEventListener('DOMContentLoaded', function() {
         // Attach click event to elements with the class "viewassetsHistory"
         document.querySelectorAll('.viewassetsHistory').forEach((element) => {
            element.addEventListener('click', function(e) {
               e.preventDefault();

               const employeeId = this.getAttribute('data-employee-id'); // Get the employee ID from the data attribute
               const modalBody = document.querySelector('#viewassetsHistoryModal .assets-request-box'); // Target modal body container

               const employeeName = this.getAttribute('data-employee-name'); // Get the employee name
               console.log(employeeName);
               const employeeCode = this.getAttribute('data-employee-code'); // Get Employee Code

               const modalTitle = document.querySelector('#viewqueryModalLabel'); // Target modal title
               const companyID = {{Auth::user()->CompanyId}};
               // Update the modal title with the employee name
               modalTitle.textContent = `Assets History Details - ${employeeName} (${employeeCode})`;

               // Clear previous content
               modalBody.innerHTML = '<p>Loading...</p>';

               // Fetch data from the server
               fetch(`/fetch-assets-history/${employeeId}`)
                  .then((response) => {
                     if (!response.ok) {
                        throw new Error('Network response was not ok');
                     }
                     return response.json();
                  })
                  .then((data) => {
                     let modalContent = '';

                     // Generate HTML content dynamically
                     data.forEach((item) => {
                        const billUrl = `/file-view/Employee_Assets/${companyID}/${item.ReqBillImgExtName || ''}`;
                        const assetUrl = `/file-view/Employee_Assets/${companyID}/${item.ReqAssestImgExtName || ''}`;

                        modalContent += `
                            <div class="col-md-6">
                                <div class="assets-req-section">
                                    <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                                        <span class="float-start"><b>Name of assets.: ${item.AssetName || '-'}</b></span>
                                    <span class="float-end">
                                    <b>Status:</b>
                                    <b class="${(item.ApprovalStatus === 2 || item.AccPayStatus === 2) ? 'success' : 'danger'}">
                                       ${(item.ApprovalStatus === 2 || item.AccPayStatus === 2) ? 'Approved' : 'Pending'}
                                    </b>
                                    </span>  
                                     </div>
                                    <div class="float-start w-100">
                                        <span class="float-start">Request Amount: <b>${item.ReqAmt || '0.00'}/-</b></span>
                                        <span class="float-end">Approval Amount: <b>${item.ApprovalAmt || '0.00'}/-</b></span>
                                    </div>
                                    <div class="float-start w-100">
                                        <span class="float-start">Company: ${item.ComName || '-'}</span>
										      <br>
                                        <span class="float-start">Dealer: ${item.DealeName || '-'}</span>
                                    </div>
                                    <div class="float-start w-100">
                                        <span class="float-start">Model: ${item.ModelNo || '-'}</span>
                                        <span class="float-end">Price: <b>${item.Price || '0.00'}/-</b></span>
                                    </div>
                                    <div class="mb-2"><p>Remarks: "${item.AnyOtherRemark || '-'}"</p></div>
                                    <div class="w-100" style="font-size:11px;">
                                        <span class="me-3"><b>Request date:</b> ${formatDateddmmyyyy(item.ReqDate) || '-'}</span>
                                    </div>
                                    <div class="w-100" style="font-size:11px;">
                                        <span class="me-3"><b>Copy:</b> 
                                          ${
                                                billUrl === '/file-view/Employee_Assets/${companyID}/' 
                                                ? `<span class="ms-2 text-muted">Bill (Not Available)</span>` 
                                                : `<a class="ms-2 link" href="${billUrl}" target="_blank">Bill</a>`
                                          }
                                          ${
                                                assetUrl === '/file-view/Employee_Assets/${companyID}/' 
                                                ? `<span class="ms-3 text-muted">Assets (Not Available)</span>` 
                                                : `<a class="ms-3 link" href="${assetUrl}" target="_blank">Assets</a>`
                                          }
                                       </span>
                                    </div>
                                </div>
                            </div>`;
                     });

                     // Update modal content
                     modalBody.innerHTML = modalContent || '<p>No asset history found.</p>';
                  })
                  .catch((error) => {
                     console.error('Error fetching asset history:', error);
                     modalBody.innerHTML = '<p>Failed to load asset history. Please try again later.</p>';
                  });
            });
         });
      });

      function viewAssetsModalFun(assetEmpReqId) {
         if (!assetEmpReqId) {
            alert('Invalid asset request ID.');
            return;
         }
         const s3BaseUrl = "{{ config('filesystems.disks.s3.url') }}"; // gets AWS_URL from config/filesystems.php

         const companyId = "{{ Auth::user()->CompanyId }}";

         $.ajax({
            url: `/assets/details/${assetEmpReqId}`,
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
               $('#loader').show();
            },
            success: function(response) {
               if (response.status === 'success') {
                  const data = response.data;
                  console.log(data.AssetCopy);

                  let billCopyUrl =  '/file-view/Employee_Assets/' + companyId + '/' + (data.BillCopy || '');
                  let assetsCopyUrl = '/file-view/Employee_Assets/' + companyId + '/' + (data.AssetCopy || '');
                  let vehiclePhotoUrl = '/file-view/Employee_Assets/' + companyId + '/' + (data.VehiclePhoto || '');
                  let rcCopyUrl = '/file-view/Employee_Assets/' + companyId + '/' + (data.RCCopy || '');
                  let dLCopyUrl = '/file-view/Employee_Assets/' + companyId + '/' + (data.DLCopy || '');
                  let insuranceCopyUrl = '/file-view/Employee_Assets/' + companyId + '/' + (data.InsuranceCopy || '');
                  let odometerReadingUrl = '/file-view/Employee_Assets/' + companyId + '/' + (data.OdometerReading || '');

                  let defaultPath = '/file-view/Employee_Assets/' + companyId + '/';

                  // let billCopyUrl = 'Employee/AssetReqUploadFile/' + (data.BillCopy || '');
                  // let assetsCopyUrl = 'Employee/AssetReqUploadFile/' + (data.AssetCopy || '');
                  // let vehiclePhotoUrl = 'Employee/AssetReqUploadFile/' + (data.VehiclePhoto || '');
                  // let rcCopyUrl = 'Employee/AssetReqUploadFile/' + (data.RCCopy || '');
                  // let dLCopyUrl = 'Employee/AssetReqUploadFile/' + (data.DLCopy || '');
                  // let insuranceCopyUrl = 'Employee/AssetReqUploadFile/' + (data.InsuranceCopy || '');
                  // let odometerReadingUrl = 'Employee/AssetReqUploadFile/' + (data.OdometerReading || '');

                  // let defaultPath = 'Employee/AssetReqUploadFile/';

                  $('#asstBillCopy')
                     .html(billCopyUrl.trim() === defaultPath ? 'Not Available' : '<i class="fas fa-file-pdf"></i>')
                     .attr('href', billCopyUrl.trim() === defaultPath ? '#' : billCopyUrl)
                     .toggleClass('disabled-link', billCopyUrl.trim() === defaultPath);

                  $('#asstAssetsCopy')
                     .html(assetsCopyUrl.trim() === defaultPath ? 'Not Available' : '<i class="fas fa-file"></i>')
                     .attr('href', assetsCopyUrl.trim() === defaultPath ? '#' : assetsCopyUrl)
                     .toggleClass('disabled-link', assetsCopyUrl.trim() === defaultPath);

                  $('#asstVehiclePhoto')
                     .html(vehiclePhotoUrl.trim() === defaultPath ? 'Not Available' : '<i class="fas fa-image"></i>')
                     .attr('href', vehiclePhotoUrl.trim() === defaultPath ? '#' : vehiclePhotoUrl)
                     .toggleClass('disabled-link', vehiclePhotoUrl.trim() === defaultPath);

                  $('#asstRCCopy')
                     .html(rcCopyUrl.trim() === defaultPath ? 'Not Available' : '<i class="fas fa-file-alt"></i>')
                     .attr('href', rcCopyUrl.trim() === defaultPath ? '#' : rcCopyUrl)
                     .toggleClass('disabled-link', rcCopyUrl.trim() === defaultPath);

                  $('#asstDLCopy')
                     .html(dLCopyUrl.trim() === defaultPath ? 'Not Available' : '<i class="fas fa-id-card"></i>')
                     .attr('href', dLCopyUrl.trim() === defaultPath ? '#' : dLCopyUrl)
                     .toggleClass('disabled-link', dLCopyUrl.trim() === defaultPath);

                  $('#asstInsuranceCopy')
                     .html(insuranceCopyUrl.trim() === defaultPath ? 'Not Available' : '<i class="fas fa-file-invoice"></i>')
                     .attr('href', insuranceCopyUrl.trim() === defaultPath ? '#' : insuranceCopyUrl)
                     .toggleClass('disabled-link', insuranceCopyUrl.trim() === defaultPath);

                  $('#asstOdometerReading')
                     .html(odometerReadingUrl.trim() === defaultPath ? 'Not Available' : '<i class="fas fa-tachometer-alt"></i>')
                     .attr('href', odometerReadingUrl.trim() === defaultPath ? '#' : odometerReadingUrl)
                     .toggleClass('disabled-link', odometerReadingUrl.trim() === defaultPath);

                  if (data.AssetNId == 1) {
                     $("#asstLimitFeild").hide();
                     $("#asstRequestAmountFeild").hide();
                     $("#asstIMEINoFeild").hide();
                     $("#asstAssetsCopyFeild").hide();
                     $("#asstVehicleBrandFeild").show();
                     $("#asstFuelTypeFeild").show();
                     $("#asstRegistrationNumberFeild").show();
                     $("#asstOwnershipFeild").show();
                     $("#asstDLCopyFeild").show();
                     $("#asstVehiclePhotoFeild").show();
                     $("#asstRCCopyFeild").show();
                     $("#asstInsuranceCopyFeild").show();
                     $("#asstOdometerReadingFeild").show();
                  } else {
                     $("#asstLimitFeild").show();
                     $("#asstRequestAmountFeild").show();
                     $("#asstIMEINoFeild").show();
                     $("#asstAssetsCopyFeild").show();
                     $("#asstVehicleBrandFeild").hide();
                     $("#asstFuelTypeFeild").hide();
                     $("#asstRegistrationNumberFeild").hide();
                     $("#asstOwnershipFeild").hide();
                     $("#asstDLCopyFeild").hide();
                     $("#asstVehiclePhotoFeild").hide();
                     $("#asstRCCopyFeild").hide();
                     $("#asstInsuranceCopyFeild").hide();
                     $("#asstOdometerReadingFeild").hide();
                  }

                  $('#asstAssetName').text(data.AssetName || '-');
                  $('#asstLimit').text(data.MaxLimitAmt || '-');
                  $('#asstModelName').text(data.ModelName || '-');
                  $('#asstModelNumber').text(data.ModelNo || '-');
                  $('#asstVehicleBrand').text(data.VehicleBrand || '-');
                  $('#asstCompanyName').text(data.CompanyName || '-');
                  $('#asstPurchaseDate').text(formatDate(data.PurchaseDate));
                  $('#asstDealerName').text(data.DealerName || '-');
                  $('#asstDealerContact').text(data.DealerContact || '-');
                  $('#asstPrice').text(data.Price || '-');
                  $('#asstBillNumber').text(data.BillNo || '-');
                  $('#asstRequestAmount').text(data.RequestAmount || '-');
                  $('#asstIMEINo').text(data.IEMINo || '-');
                  $('#asstRegistrationNumber').text(data.RegistrationNumber || '-');
                  $('#asstRegistrationDate').text(formatDate(data.RegistrationDate));
                  $('#asstOwnership').text(data.Ownership || '-');
                  $("#asstRemark").text(data.Remarks || '-');
                  $('#asstBillCopy').attr('href', billCopyUrl);
                  $('#asstAssetsCopy').attr('href', assetsCopyUrl);
                  $('#asstVehiclePhoto').attr('href', vehiclePhotoUrl);
                  $('#asstDLCopy').attr('href', dLCopyUrl);
                  $('#asstRCCopy').attr('href', rcCopyUrl);
                  $('#asstInsuranceCopy').attr('href', insuranceCopyUrl);
                  $('#asstOdometerReading').attr('href', odometerReadingUrl);
                  $("#HODApprovalStatus").text(getStatusMeaning(data.HODApprovalStatus) || '-');
                  $("#HODApprovalRemarks").text(data.HODRemark || '-');
                  $("#HODApprovalDate").text(formatDate(data.HODSubDate));
                  $("#ITApprovalStatus").text(getStatusMeaning(data.ITApprovalStatus) || '-');
                  $("#ITApprovalRemarks").text(data.ITRemark || '-');
                  $("#ITApprovalDate").text(formatDate(data.ITSubDate));
                  $("#AccPayStatus").text(getStatusMeaning(data.AccPayStatus) || '-');
                  $("#AccPayRemarks").text(data.AccRemark || '-');
                  $("#AccPayDate").text(formatDate(data.AccSubDate));
                  $("#asstFuelType").text(data.FuelType || '-');

                  data.HODApprovalStatus > 0 && data.HODSubDate ? $('#HODFeild').show() : $('#HODFeild').hide();
                  data.ITApprovalStatus > 0 && data.ITSubDate ? $('#ITFeild').show() : $('#ITFeild').hide();
                  data.AccPayStatus > 0 && data.AccSubDate ? $('#AccPayFeild').show() : $('#AccPayFeild').hide();
               } else {
                  alert(response.message || 'Failed to fetch asset details.');
               }
            },
            complete: function() {
               $('#loader').hide();
            },
            error: function() {
               alert('Failed to fetch asset details. Please try again.');
            },
         });
      }

      function formatDate(dateString) {
         if (!dateString) return '-';
         const date = new Date(dateString);
         if (isNaN(date)) return '-';
         const day = String(date.getDate()).padStart(2, '0');
         const month = String(date.getMonth() + 1).padStart(2, '0');
         const year = date.getFullYear();
         return `${day}-${month}-${year}`;
      }

      function getStatusMeaning(status) {
         switch (status) {
            case 0:
               return "Draft";
            case 1:
               return "Pending";
            case 2:
               return "Approved";
            case 3:
               return "Disapproved";
            case 4:
               return "Forward";
            default:
               return "-";
         }
      }

      function formatDateddmmyyyy(date) {
         if (!date) return '';
         const d = new Date(date);
         return d.getDate().toString().padStart(2, '0') + '/' + (d.getMonth() + 1).toString().padStart(2, '0') + '/' + d.getFullYear();
      }

      document.addEventListener("DOMContentLoaded", function() {
         setTimeout(function() {
            let activeTab = document.querySelector(".nav-link.active");
            console.log("Active Tab:", activeTab); // Debugging output

            // If no active tab is found, manually activate the first tab with content
            if (!activeTab) {
               let tabs = document.querySelectorAll(".nav-link[data-bs-toggle='tab']");
               for (let tab of tabs) {
                  let tabContent = document.querySelector(tab.getAttribute("href"));

                  if (tabContent && tabContent.innerHTML.trim() !== "") {
                     let firstTab = new bootstrap.Tab(tab); // Use Bootstrap's tab activation
                     firstTab.show();
                     console.log("New Active Tab:", tab); // Debugging output
                     break;
                  }
               }
            }
         }, 500); // Delay to allow Bootstrap to initialize
      });
      document.addEventListener('DOMContentLoaded', function() {
         const approvalStatusSelect = document.getElementById('approval_status');
         const approvalDateLabel = document.querySelector('label[for="approval_date"]');

         approvalStatusSelect.addEventListener('change', function() {
            if (this.value === '3') { // '3' corresponds to 'Rejected'
               approvalDateLabel.innerHTML = '<b>Rejection Date</b>';
            } else {
               approvalDateLabel.innerHTML = '<b>Approval Date</b>';
            }
         });
      });
      document.addEventListener('DOMContentLoaded', () => {
         const statusFilter = document.getElementById('acctStatusAllFilter');
         const fromDate = document.getElementById('fromDate');
         const toDate = document.getElementById('toDate');
         const empcode = document.getElementById('Empcodefilter'); // Correct ID

         const exportStatus = document.getElementById('exportAcctStatus');
         const exportFromDate = document.getElementById('exportFromDate');
         const exportToDate = document.getElementById('exportToDate');
         const exportEmpcode = document.getElementById('exportEmpcode');

         const rows = document.querySelectorAll('#assetsTableAll tbody tr');

         const statusMap = {
            '0': 'draft',
            '2': 'approved',
            '3': 'rejected',
            '': ''
         };

         function filterTable() {
            const statusVal = statusFilter?.value || '';
            const fromVal = fromDate?.value ? new Date(fromDate.value) : null;
            const toVal = toDate?.value ? new Date(toDate.value) : null;
            const empcodeVal = empcode?.value.trim().toLowerCase() || '';

            const isFiltering = statusVal || fromVal || toVal || empcodeVal;

            rows.forEach(row => {
                  if (!isFiltering) {
                     row.style.display = '';
                     return;
                  }

                  const statusSpan = row.querySelector('td .acctapproved, td .acctreject, td .acctdraft');
                  const statusText = statusSpan ? statusSpan.textContent.trim().toLowerCase() : '';

                  const empcodeSpan = row.querySelector('.empcodefiltertd'); // Class in your table cell
                  const rowEmpcode = empcodeSpan ? empcodeSpan.textContent.trim().toLowerCase() : '';

                  const reqDateCell = row.querySelector('.datereq');
                  const reqDateText = reqDateCell ? reqDateCell.textContent.trim() : '';
                  const rowDate = reqDateText ? new Date(reqDateText.split('-').reverse().join('-')) : null;

                  const matchStatus = !statusVal || statusText.includes(statusMap[statusVal]);
                  const matchEmpcode = !empcodeVal || rowEmpcode.includes(empcodeVal);

                  let matchDate = true;
                  if (fromVal && rowDate) matchDate = rowDate >= fromVal;
                  if (toVal && rowDate) matchDate = matchDate && rowDate <= toVal;

                  row.style.display = (matchStatus && matchEmpcode && matchDate) ? '' : 'none';
            });

            // ✅ Sync export hidden inputs
            if (exportStatus) exportStatus.value = statusVal;
            if (exportFromDate) exportFromDate.value = fromDate?.value || '';
            if (exportToDate) exportToDate.value = toDate?.value || '';
            if (exportEmpcode) exportEmpcode.value = empcode?.value || '';
         }

         // ✅ Attach listeners to filters
         statusFilter?.addEventListener('change', filterTable);
         fromDate?.addEventListener('change', filterTable);
         toDate?.addEventListener('change', filterTable);
         empcode?.addEventListener('input', filterTable); // Real-time filtering

         // ✅ Initial load
         filterTable();

         // ✅ Sync export filters before submit (optional safeguard)
         const exportForm = document.getElementById('exportForm');
         if (exportForm) {
            exportForm.addEventListener('submit', function () {
                  filterTable(); // Ensure latest filter values synced
            });
         }
      });

      document.getElementById('declaration_agreed').addEventListener('change', function () {
         const formActions = document.getElementById('form-actions');
         if (this.checked) {
            formActions.style.display = 'block';
         } else {
            formActions.style.display = 'none';
         }
      });

   </script>
   <script src="{{ asset('../js/dynamicjs/assests.js/') }}" defer></script>
   <style>
      #loader {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(255, 255, 255, 0.7);
         display: flex;
         justify-content: center;
         align-items: center;
         z-index: 9999;
      }

      .spinner-border {
         width: 3rem;
         height: 3rem;
      }

      #assestapprovaltable thead tr th {
         border: 1px solid #cbcbcb;
      }

      .card-header {
         display: flex;
         justify-content: center;
         align-items: center;
         text-align: center;
      }

      .dflex {
         display: flex;
         justify-content: space-between !important;
         align-items: center;
         width: 100%;
      }

      .has-btn {
         margin-right: 10px;
      }

      .disabled-link {
         pointer-events: none;
         cursor: default;
         color: #888;
         text-decoration: none;
      }
   </style>
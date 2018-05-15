<!--  EXTENDING LAYOUT -->
@extends('layouts.app')


<!--  INSERTING SECTION TO LAYOUT -->
@section('content')
<!-- CONTAINER COL -->
<div class="col-8 col-sm-9 col-md-9 col-lg-9 col-xl-10">
<div class="block-75"></div>



	<!-- FORM PAGINATION -->
	<ul class="pagination mb-o">
		<li class="page-item disabled">
			<a class="page-link font-weight-bold text-primary" href="#">
				Information <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
			</a>
		</li>
		<li class="page-item" >
        		<a class="page-link " href="{{ url('/clients/create') }}">
        			Basic
        		</a>
        	</li>
    		<li class="page-item active">
    			<a class="page-link" href="{{ url('/medicals/create') }}">
    				Medical
    			</a>
    		</li>
	</ul><!-- ../FORM PAGINATION -->
	<!-- CARD -->
    <div class="card ml-2 mr-2">
    <div class="card-header text-primary">
        <i class="fa fa-list-alt fa-lg"></i>
    		Creating Medical Record...
    	</div>
    	
    	<!-- CREATE NEW CLIENT FORM -->
    	<form method="POST" action="{{ url('/clients') }}" >
    	
    	<!-- CARD-BODY -->
    	<div class="card-body">
   
    		<!-- CARD-TITLE -->
    		<div class="card-title text-muted">
    			Please, provide the following details.
    		</div><!-- ../CARD-TITLE -->
    		<hr/>
    		
    		
    	<!-- FORM-ROW -->
    		<div class="form-row">
    		<!-- DERMATOLOGIST -->
    				<!-- FORM-GROUP COL -->
    				<div class="form-group col">
    					<!-- col -->
    					<label>
    						<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
    						3. Currently under a Dermatologist?	
    					</label>
    					<!-- col -->
    					<div class="col">
    						<div class="form-check form-check-inline">
    							<label class="form-check-label">
    								<input name="dermatologist" class="form-check-input" type="checkbox" value="true">Yes
    							</label>
							</div>
    						<div class="form-check form-check-inline">
    							<label class="form-check-label">
            						<input name="dermatologist" class="form-check-input" type="checkbox" value="false">No
          					</label>
    						</div>
    					</div>
    				</div><!-- ../FORM-GROUP COL -->
        <!-- PREGNANT -->
    				<!-- FORM GROUP COL -->
    				<div class="form-group col">
    					<label>
    						<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
    						4. (Female)	 Are you currently pregnant? 
    					</label>
    					<div class="col">
    						<div class="form-check form-check-inline">
    							<label class="form-check-label">
    								<input name="pregnant" class="form-check-input" type="checkbox" value="true">Yes
    							</label>
							</div>
    						<div class="form-check form-check-inline">
    							<label class="form-check-label">
            						<input name="pregnant" class="form-check-input" type="checkbox" value="false">No
          					</label>
    						</div>
    					</div>
    			    </div><!-- ../FORM GROUP COL -->
    		</div><!-- ../FORM-ROW -->
    	
    		<br/>
    	
    	<!-- FORM-ROW -->
    		<div class="form-row">
	    <!-- SKIN RELATED MEDICATIOS -->
    				<!-- FORM-GROUP COL -->
    				<div class="form-group col">
    					<label>
    						<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
    						5. Are you taking any of these medications?
    					</label>
    					<select multiple class="form-control">
    						<option> -Azlex </option>
    						<option> -Diferin </option>
    						<option> -Renova </option>
    						<option> -Retin-A </option>
    						<option> -Tazarac </option>
    						<option> -Glycolic </option>
    						<option> -Alpha Hydroxy Acids</option>
    					</select>
    			    </div><!-- ../COL -->
    			    
    		<!-- ACUTANE -->
    			    <!-- FORM-GROUP COL -->
    			    <div class="form-group col">
    			    		<label >
    						<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
    						6. Currently using Acutane?
    					</label>
    					<div class="col">
    						<div class="form-check form-check-inline">
    							<label class="form-check-label">
    								<input name="acutane" class="form-check-input" type="checkbox" value="true">Yes
    							</label>
							</div>
    						<div class="form-check form-check-inline">
    							<label class="form-check-label">
            						<input name="acutane" class="form-check-input" type="checkbox" value="false">No
          					</label>
    						</div>
    					</div>
    			    </div>
    		</div><!-- FORM-ROW -->
    		
    		<br/>
    		
    	<!-- FORM-ROW -->
    		<div class="form-row">
    		<!-- STRESS LEVEL -->
    			<!-- FROM-GROUP COL -->
    			<div class="form-group col">
    				<label>
					<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
					7. What is your stress level?
    				</label>
    				<div class="col">
            			<div class="form-check form-check-inline">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"> 1
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"> 2
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"> 3
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"> 4
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"> 5
                      </label>
                    </div>
                </div>
    			</div>
		<!-- IMPLANTS -->
			<!-- FORM-GROUP COL -->
			<div class="form-group col">
				<label>
					8a. Do you have any implants?
				</label>
				<input name="metal_implants" type="text" class="form-control" placeholder="Implant locations...">
		    </div><!-- ../COL -->
    		</div><!-- ../FORM-ROW -->
    		
    		<br/>
    		
    	<!-- FORM-ROW -->
    		<div class="form-row">
    		<!-- PACEMAKER -->
    		    <!-- FORM-GROUP COL -->
    			<div class="form-group col">
				<label>
					<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
					8b. Pacemaker?
				</label>
				<div class="col">
    						<div class="form-check form-check-inline">
    							<label class="form-check-label">
    								<input name="pacemaker" class="form-check-input" type="checkbox" value="true">Yes
    							</label>
							</div>
    						<div class="form-check form-check-inline">
    							<label class="form-check-label">
            						<input name="pacemaker" class="form-check-input" type="checkbox" value="false">No
          					</label>
    						</div>
    					</div>
			</div><!-- ../FORM-GROUP COL -->	
    		
    		<!-- SURGERY -->
    			<!-- FORM-GROUP COL -->
    			<div class="form-group col">
    				<label>
    					9. Surgery?
    				</label>
				<input name="surgery" type="text" class="form-control" placeholder="Surgery loctions...">
    			</div><!-- ../FORM-GROUP COL -->
    		</div><!-- ../FORM-ROW -->
    		
    		<br/>
    		
    	<!-- FORM-ROW -->
    		<div class="form-row">
    		
    		<!-- ALTERNATE MEDICATIONS -->
    			<!-- FORM-GROUP COL -->
    			<div class="form-group col">
    				<label>
    					10. What medications are you taken?
    				</label>
				<input name="metal_implants" type="text" class="form-control" placeholder="Name of Medication...">
    			</div><!-- ../FORM-GROUP COL -->
    			
    		<!-- GLASSES -->
		    <!-- FORM-GROUP COL -->
		    <div class="form-group col">
		    		<label >
					<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
					11. Currently using Glasses?
				</label>
				<div class="col">
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input name="glasses" class="form-check-input" type="checkbox" value="true">Yes
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label">
    						<input name="glasses" class="form-check-input" type="checkbox" value="false">No
  					</label>
					</div>
				</div>
		    </div><!-- ../FORM-GROUP COL -->		    
    		</div><!-- ../FORM-ROW -->
    		
    		<br/>
    	<!-- FORM-ROW -->
    		<div class="form-row">
    		<!-- SMOKE -->
		    <!-- FORM-GROUP COL -->
		    <div class="form-group col">
		    		<label >
					<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
					12. Do you smoke?
				</label>
				<div class="col">
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input name="smoke" class="form-check-input" type="checkbox" value="true">Yes
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label">
    						<input name="smoke" class="form-check-input" type="checkbox" value="false">No
  					</label>
					</div>
				</div>
		    </div><!-- ../FORM-GROUP COL -->
		<!-- ALLERGIES -->
    			<!-- FORM-GROUP COL -->
    			<div class="form-group col">
    				<label>
    					<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
    					13. Do you have any allergic reaction?(food,cosmetics,medicine,latex)
    				</label>
				<input name="allergies" type="text" class="form-control" placeholder="Allergic reaction...">
    			</div><!-- ../FORM-GROUP COL -->
    		</div><!-- ../FORM-ROW -->
    		
    		<br/>
    		
    	<!-- FORM-ROW -->
    		<div class="form-row">
    		<!-- SKIN CANCER -->
		    <!-- FORM-GROUP COL -->
		    <div class="form-group col">
		    		<label >
					<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
					14. Have you been diagnosed with skin cancer?
				</label>
				<div class="col">
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input name="skin_cancer" class="form-check-input" type="checkbox" value="true">Yes
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label">
    						<input name="skin_cancer" class="form-check-input" type="checkbox" value="false">No
  					</label>
					</div>
				</div>
		    </div><!-- ../FORM-GROUP COL -->
	   <!-- SKIN-PRODUCTS -->
    			<!-- FORM-GROUP COL -->
    			<div class="form-group col">
    				<label>
    					<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
    					15. Are you currently using any skin related products?
    				</label>
				<input name="allergies" type="text" class="form-control" placeholder="Allergic reaction...">
    			</div><!-- ../FORM-GROUP COL -->
    		</div>
    		
    		
    		
    	</div><!-- ../CARD-BODY -->
    	
    	<!-- CARD-FOOTER -->
    	<div class="card-footer">
    		<!-- SUBMIT BUTTON -->
    		<div class="form-group row">
              	<div class="col d-flex justify-content-center">
                		<button type="submit" class="btn btn-primary">Save Record</button>
              	</div>
             </div>
    	</div><!-- ../CARD-FOOTER -->
    	
    	</form><!-- ../CREATE NEW CLIENT FORM -->
    </div><!-- ../CARD -->
    
    
    
</div><!-- ../CONTAINER COL -->
@endsection
<!-- ../INSERTING SECTION TO LAYOUT -->













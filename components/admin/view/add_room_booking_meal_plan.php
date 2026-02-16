            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12" id="add_meal_plans">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">ADD MEAL PALN</h4>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="col-12">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="meal_plan_name">Meal Plan Name <span class="required-span">*</span></label>
                                        <input type="text" class="form-control" name="meal_plan_name" id="meal_plan_name" placeholder="Enter Meal Plan Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="price">Price Per Head <span class="required-span">*</span></label>
                                        <input type="number" class="form-control form-control" name="price" id="price"  placeholder="Enter Price Per Head" step="0.01">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="meal_plan_includes">Meal Plan Includes <span class="required-span">*</span></label>
                                        <input type="text" class="form-control" name="meal_plan_includes" id="meal_plan_includes"  placeholder="Meal Plan Includes">
                                    </div>
                                </div>
                                <div class="row ml-1 mt-1">
                                    <span><span class="required-span">*</span> Required fields.</span>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <input type="button" value="SUBMIT" class="btn btn-lg btn-success" id="btn_add" onclick="addMealPlan()">
                                        <small id="response" class="text-success" style="display:none"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
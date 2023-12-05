
@if(isset($employee_increase))
                @if(count($employee_increase) > 0)
                <h4>Add New Employee</h4>
                <table class="table" id="reports" style="font-size:9px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($employee_increase))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                            @foreach ($employee_increase as $row)

                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>

                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endif
                @endif

                @if(isset($employee_decrease))
                @if(count($employee_decrease) > 0)
                <h4>Less Terminated Employee</h4>
                <table class="table" id="reports" style="font-size:9px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($employee_decrease))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                            @foreach ($employee_decrease as $row)

                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>

                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endif
                @endif
                @if(isset($basic_increase))
                @if(count($basic_increase) > 0)
                <h4>Add Increase in Basic Pay Comparison to Last M</h4>
                <table class="table" id="reports" style="font-size:9px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($basic_increase))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                            @foreach ($basic_increase as $row)

                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>

                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endif
                @endif
                @if(isset($basic_decrease))
                @if(count($basic_decrease) > 0)
                <br>
                <h4>Less Decrease in Basic Pay Comparison to Last M</h4>
                <table class="table" id="reports" style="font-size:9px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($basic_decrease))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                            @foreach ($basic_decrease as $row)

                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>

                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endif
                @endif
                @foreach($names as $name)
                <h4>{{ $name == 'Add/Less N-Overtime'? 'Add/Less Normal Day Overtime':($name == 'Add/Less S-Overtime' ? 'Add/Less Sunday Overtime':$name) }}</h4>

                <table class="table" id="reports" style="font-size:9px; ">
                    <thead>
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($allowances))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                            @foreach ($allowances as $row)
                            @if($row->description == $name)
                            @if($row->description == "Add/Less S-Overtime")
                            @if($row->previous_amount != $row->current_amount)
                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>
                            @endif
                            @else
                            @php
                            $total_previous += $row->previous_amount;
                            $total_current += $row->current_amount;
                            $total_amount += ($row->current_amount - $row->previous_amount);
                             @endphp
                        <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                            <td class="text-end">{{ $row->emp_id }}</td>



                            <td class="text-end">{{ $row->fname }}</td>

                            <td class="text-end">{{ $row->lname }}</td>


                            <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                            <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                            <td class="text-end">
                                {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                            <td class="text-end">{{ $row->hire_date }}</td>

                            <td class="text-end">{{ number_format(0, 0) }}
                            </td>


                        </tr>

                            @endif
                            @endif
                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endforeach
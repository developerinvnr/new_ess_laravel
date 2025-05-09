
<table>
																<thead>
																	<tr>
																		<th rowspan="2" class="text-center">SN.</th>
																		<th rowspan="2" class="text-center">EC</th>
																		<th rowspan="2" style="width:110px;">Name</th>
																		<th rowspan="2" class="text-center" style="width:63px;">DOJ</th>
																		<th rowspan="2" class="text-center" style="width:75px;">Department</th>
																		<th rowspan="2" class="text-center" style="width:95px;">Designation</th>
																		<th rowspan="2" class="text-center">Grade</th>
																		<th rowspan="2" class="text-center">Grade<br>Change<br>Year</th>
																		<th class="text-center" colspan="2">Last<br>Correction</th>
																		<th class="text-center" colspan="1">Previous<br>CTC</th>
																		<th class="text-center" colspan="8">Proposed</th>
																		<th class="text-center" colspan="3">Total Proposed</th>
																	</tr>
																	<tr>
																		<th class="text-center">%</th>
																		<th class="text-center" style="width:48px;">Year</th>
																		<th class="text-center">Fixed</th>
																		<th class="text-center">Rating</th>
																		<th class="text-center">Designation</th>
																		<th class="text-center">Grade</th>
																		<th style="width:35px;" class="text-center">Pro.<br>Rata<br>(%)</th>
																		<th class="text-center">Actual<br>(%)</th>
																		<th class="text-center">CTC</th>
																		<th class="text-center">Corr.</th>
																		<th class="text-center">Corr.<br>(%)</th>
																		<th style="width:60px;" class="text-center">Inc</th>
																		<th class="text-center">CTC</th>
																		<th style="width:35px;" class="text-center">Final<br>(%)</th>
																	</tr>
																</thead>
																<tbody>
																@foreach ($baseQueryMain as $item)
																	<tr style="background-color: #f9f9f9; font-weight: bold;">
																		<td colspan="10" class="text-end">Summary</td>
																		<td class="text-center">{{ $item->pre_ctc }}</td>
																		<td></td> {{-- Rating header placeholder --}}
																		<td></td> {{-- Proposed Designation --}}
																		<td></td> {{-- Proposed Grade --}}
																		<td class="text-center">{{ $item->per_prorata }}</td>
																		<td class="text-center">{{ $item->per_actual }}</td>
																		<td class="text-center">{{ $item->ctc }}</td>
																		<td class="text-center">{{ $item->corr }}</td>
																		<td class="text-center">{{ $item->per_corr }}</td>
																		<td class="text-center">{{ $item->inc }}</td>
																		<td class="text-center">{{ $item->tot_ctc }}</td>
																		<td class="text-center">{{ $item->per_totctc }}</td>
																	</tr>
																@endforeach
																	@foreach($employeeTableData as $index => $row)
																	
																	<tr >
																		<td class="text-center">{{ $index + 1 }}</td>
																		
																		<td class="text-center">{{ $row['EmpCode'] }}</td>
																		<td >{{ $row['FullName'] }}</td>
																		<td class="text-center">{{ \Carbon\Carbon::parse($row['DateJoining'])->format('d M y') }}</td>
																		<td class="text-center">{{ $row['Department'] }}</td>
																		<td>{{ $row['Designation'] }}</td>
																		<td class="text-center">{{ $row['Grade'] }}</td>
																		<td class="text-center">{{ $row['MxGrDate'] }}</td>
																		<td class="text-center">{{ $row['MxCrPer'] }}</td>
																		<td class="text-center">{{ $row['MxCrDate'] }}</td>
																		<td class="text-center">{{ $row['PrevFixed']}}</td>
																		<td class="text-center"><b>{{ $row['Rating'] }}</b></td>
																		<td class="text-center">{{ $row['ProDesignation'] }}</td>
																		<td class="text-center">{{ $row['ProGrade'] }}</td>
																		<td class="text-center">{{ $row['ProRata'] }}</td>
																		<td>{{ $row['Actual']}}</td>
																		<td class="text-center">{{ fmod($row['CTC'], 1) == 0 ? (int)$row['CTC'] : rtrim(rtrim(number_format($row['CTC'], 2, '.', ''), '0'), '.') }}
																		</td>

																		<td>{{ $row['Corr'] }}</td>
																		<td class="text-center">{{ $row['CorrPer'] }}</td>
																		<td class="text-center">{{ $row['Inc'] }}</td>
																		<td class="text-center">{{ $row['TotalCTC'] }}</td>
																		<td class="text-center">{{ $row['TotalCTCPer'] }}</td>
																		

																	</tr>
																	
																	@endforeach
																</tbody>
															</table>
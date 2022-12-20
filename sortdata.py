from openpyxl import load_workbook

file = "test.xlsx" #load the work book
wb_obj = load_workbook(filename = 'payslips_xls.xlsx')
wsheet = wb_obj['payslips']
dataDict = {}

data={}

#ID	CompanyCode	FISCALYEAR	Mon	MonthName	CODENO	Group	GroupNo	Position	Desc	Value	Name	Department	Description	BANKNAME	BRANCH	PayMethod	NPFNUMBER	JobTitle	msg1	msg2	msg3	Wstation	WStation_Name	Hired_Date	STATUS	upsize_ts
#0	 1	              2   	3	       4	5	      6	       7    	8	     9	        10	11	      12	     13	           14	      15	16	           17	       18	     19	      20	21	      22	      23	            24	       25	26



#id	empID	salary	allowances	pension_employee	pension_employer	medical_employee	medical_employer	taxdue	meals	department	position	branch	pension_fund	membership_no	sdl	wcf	less_takehome	due_date	payroll_date	bank	bank_branch	account_no	created_at	updated_at
#1   	2	 3	     4	         5	                  6	                  7	                    8	              9	     10	     11	         12	          13	    14	              15         16	 17 	18	        19	        20	            21	        22	                    23	        24	25

for key, *values in wsheet.iter_rows():
    temp={}
    date='25/'+str(values[2].value)+'/'+str(values[1].value)
    # print(date)
    # for value in values:

    # dataDict[key.value] = [v.value for v in values]
    # print(dataDict[key.value])

    # for key in dataDict:
    #     print(dataDict[key][3])
    temp[1]=values[4].value  #empID
    # print(values[8].value)

    if("    Desc"):
        j=0
    # elif("9"):

    # elif("Taxable Gross"):

    # elif("Gross pay"):

    # elif("Total Deduction"):

    # elif("Less: Tax free Pension"):

    # elif("Take home"):

    # elif("NULL"):

    # elif("Net pay"):

    # elif("Total Income"):

    # elif("Net Tax"):

    # elif("PAYE"):

    elif("Basic Pay"):
         temp[2]=values[3].value  #salary

    elif("Net Basic"):
        temp[2]=values[3].value  #salary

    # elif("NSSF"):

    # elif("Normal O/T Amount"):

    # elif("Arrears"):

    elif("Leave Balance"):
        temp[3]=values[9].value  #allowances

    # elif("Teller/Back Off"):

    # elif("S0263.0001.2003"):

    # elif("S2476.0032.2007"):

    # elif("E0015.3226.2012"):

    # elif("S0302.0218.2010"):

    # elif("S0208.0041.2005"):

    # elif("S0306.0193.2011"):

    # elif("S0222.0156.2010"):

    elif("Task Allowance"):
        temp[3]=values[9].value  #allowances

    # elif("S1818.0246.2010"):

    # elif("S0756.0003.2009"):

    # elif("S0195.0094.2012"):

    # elif("S0731.0115.2008"):

    # elif("Normal Overtime Hrs"):

    # elif("Sundays O/T Hours"):

    # elif("WeekDay Overtime @1.5"):

    # elif("Sundays Overtime @2.0"):

    # elif("Rounding"):

    # elif("S0264.0062.2008"):

    # elif("Acting Allowanc"):

    # elif("S1626.0095.2011"):

    # elif("Disturbance All"):

    # elif("N/Shift Allowan"):

    # elif("Transport Allow"):

    # elif("S0423.0180.2006"):

    # elif("Unpaid Leave"):

    # elif("O/Stand Leave"):

    # elif("Leave Allowance"):

    # elif("S0960.0313.2009"):

    # elif("House Rent"):

    # elif("Air Ticket Allo"):

    # elif("Hse Loan/Rent"):

    # elif("Vehicle Benefit"):

    # elif("Bonus"):

    # elif("ADVANCE"):

    # elif("Mid Month Advances"):

    # elif("Sundays O/T Amount"):

    # elif("Leave allowance"):

    # elif("Services Award"):

    # elif("Share All. Pymt"):

    elif("SalaryPaid"):

        temp[2]=values[3].value  #salary

    # elif("E"):

    # elif(" Add:  Loan benefit"):

    # elif("Leavel&O/Stand"):

    # elif("Long Service"):

    # elif("Recognition"):

    # elif("TRA Cost"):

    # elif("Unpaid Days"):



    
    
    
    temp[4]=values[2].value  #pension_employee
    temp[5]=values[2].value  #pension_employer
    temp[6]=values[2].value  #medical_employee
    temp[7]=values[2].value  #medical_employer
    temp[8]=values[2].value  #taxdue
    temp[9]=values[2].value  #meals
    temp[10]=values[2].value  #department
    temp[12]=values[2].value  #position
    temp[13]=values[2].value  #branch
    temp[14]=values[2].value  #pension_fund
    temp[15]=values[2].value  #membership_no
    temp[16]=values[2].value  #sdl
    temp[17]=values[2].value  #wcf
    temp[18]=values[2].value  #less_takehome
    temp[19]=values[2].value  #due_date
    temp[20]=values[2].value  #payroll_date
    temp[21]=values[2].value  #bank
    temp[22]=values[2].value  #bank_branch
    temp[23]=values[2].value  #account_no
    temp[24]=values[2].value  #created_at


data[values[5].value+date]=[]
i=0
for key in data:
    print(key)
    if("i+=1"):

# prelse int(i)
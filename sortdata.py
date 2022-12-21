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
k=0
r=0
temp=[]
while r<30:
    temp.append('')
    r+=1
    # print(r)
for key, *values in wsheet.iter_rows():
    temp={}
    if(k>=1):


        # date='25/'+str(values[2].value)+'/'+str(values[1].value)
        date='25/'+str(values[2].value)+'/'+str(values[1].value)
        # print(date)
        # for value in values:
        if date not in data:
            
            
            data[str(values[4].value)+date]=temp

        # dataDict[key.value] = [v.value for v in values]
        # print(dataDict[key.value])

        # for key in dataDict:
        #     print(dataDict[key][3])
        data[str(values[4].value)+date][1]=values[4].value  #empID
        # print(values[8].value)

        if(values[8].value == "    Desc"):
            j=0
        # elif(values[8].value == "9"):

        # elif(values[8].value == "Taxable Gross"):

        # elif(values[8].value == "Gross pay"):

        # elif(values[8].value == "Total Deduction"):

        # elif(values[8].value == "Less: Tax free Pension"):

        # elif(values[8].value == "Take home"):

        # elif(values[8].value == "NULL"):

        # elif(values[8].value == "Net pay"):

        # elif(values[8].value == "Total Income"):

        # elif(values[8].value == "Net Tax"):

        # elif(values[8].value == "PAYE"):

        elif(values[8].value == "Basic Pay"):
            data[str(values[4].value)+date][2]=values[9].value  #salary

        elif(values[8].value == "Net Basic"):
            data[str(values[4].value)+date][2]=values[9].value  #salary

        # elif(values[8].value == "NSSF"):

        # elif(values[8].value == "Normal O/T Amount"):

        # elif(values[8].value == "Arrears"):

        elif(values[8].value == "Leave Balance"):
            data[str(values[4].value)+date][3]=values[9].value  #allowances

        # elif(values[8].value == "Teller/Back Off"):

        # elif(values[8].value == "S0263.0001.2003"):

        # elif(values[8].value == "S2476.0032.2007"):

        # elif(values[8].value == "E0015.3226.2012"):

        # elif(values[8].value == "S0302.0218.2010"):

        # elif(values[8].value == "S0208.0041.2005"):

        # elif(values[8].value == "S0306.0193.2011"):

        # elif(values[8].value == "S0222.0156.2010"):

        elif(values[8].value == "Task Allowance"):
            data[str(values[4].value)+date][3]=values[9].value  #allowances

        # elif(values[8].value == "S1818.0246.2010"):

        # elif(values[8].value == "S0756.0003.2009"):

        # elif(values[8].value == "S0195.0094.2012"):

        # elif(values[8].value == "S0731.0115.2008"):

        # elif(values[8].value == "Normal Overtime Hrs"):

        # elif(values[8].value == "Sundays O/T Hours"):

        # elif(values[8].value == "WeekDay Overtime @1.5"):

        # elif(values[8].value == "Sundays Overtime @2.0"):

        # elif(values[8].value == "Rounding"):

        # elif(values[8].value == "S0264.0062.2008"):

        # elif(values[8].value == "Acting Allowanc"):

        # elif(values[8].value == "S1626.0095.2011"):

        # elif(values[8].value == "Disturbance All"):

        elif(values[8].value == "N/Shift Allowan"):
            data[str(values[4].value)+date][3]=values[9].value  #allowances

        # elif(values[8].value == "Transport Allow"):

        # elif(values[8].value == "S0423.0180.2006"):

        # elif(values[8].value == "Unpaid Leave"):

        # elif(values[8].value == "O/Stand Leave"):

        elif(values[8].value == "Leave Allowance"):
            data[str(values[4].value)+date][3]=values[9].value  #allowances

        # elif(values[8].value == "S0960.0313.2009"):

        # elif(values[8].value == "House Rent"):

        # elif(values[8].value == "Air Ticket Allo"):

        # elif(values[8].value == "Hse Loan/Rent"):

        # elif(values[8].value == "Vehicle Benefit"):

        # elif(values[8].value == "Bonus"):

        # elif(values[8].value == "ADVANCE"):

        # elif(values[8].value == "Mid Month Advances"):

        # elif(values[8].value == "Sundays O/T Amount"):

        elif(values[8].value == "Leave allowance"):
            data[str(values[4].value)+date][3]=values[9].value  #allowances

        # elif(values[8].value == "Services Award"):

        # elif(values[8].value == "Share All. Pymt"):

        elif(values[8].value == "SalaryPaid"):
            data[str(values[4].value)+date][2]=values[9].value  #salary

        # elif(values[8].value == "E"):

        # elif(values[8].value == " Add:  Loan benefit"):

        # elif(values[8].value == "Leavel&O/Stand"):

        # elif(values[8].value == "Long Service"):

        # elif(values[8].value == "Recognition"):

        # elif(values[8].value == "TRA Cost"):

        # elif(values[8].value == "Unpaid Days"):

        data[str(values[4].value)+date][4]=values[2].value  #pension_employee
        data[str(values[4].value)+date][5]=values[2].value  #pension_employer
        data[str(values[4].value)+date][6]=values[2].value  #medical_employee
        data[str(values[4].value)+date][7]=values[2].value  #medical_employer
        data[str(values[4].value)+date][8]=values[2].value  #taxdue
        data[str(values[4].value)+date][9]=values[2].value  #meals
        data[str(values[4].value)+date][10]=values[2].value  #department
        data[str(values[4].value)+date][12]=values[2].value  #position
        data[str(values[4].value)+date][13]=values[2].value  #branch
        data[str(values[4].value)+date][14]=values[2].value  #pension_fund
        data[str(values[4].value)+date][15]=values[2].value  #membership_no
        data[str(values[4].value)+date][16]=values[2].value  #sdl
        data[str(values[4].value)+date][17]=values[2].value  #wcf
        data[str(values[4].value)+date][18]=values[2].value  #less_takehome
        data[str(values[4].value)+date][19]=date  #due_date
        data[str(values[4].value)+date][20]=date  #payroll_date
        data[str(values[4].value)+date][21]=values[2].value  #bank
        data[str(values[4].value)+date][22]=values[2].value  #bank_branch
        data[str(values[4].value)+date][23]=values[2].value  #account_no
        data[str(values[4].value)+date][24]=values[2].value  #created_at
    k+=1

i=0
for key in data:
    print(data[key])
    # if(values[8].value == "i+=1"):

# prelse int(i)
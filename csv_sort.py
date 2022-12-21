import csv
j=0
with open("payslips.csv", "r") as f:
    reader = csv.reader(f, delimiter="\t")
    for i, line in enumerate(reader):
        # print ('line[{}] = {}'.format(i, line))
        print(line[0][1],line[0][2],line[0][3],line[0][4])
        j=j+1
        if(j>1):
            break


# data=[[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6],[1,2,4,5,6]]
# Write CSV file
with open("test.csv", "wt") as fp:
    writer = csv.writer(fp, delimiter=",")
    # writer.writerow(["your", "header", "foo"])  # write header
    writer.writerows(data)
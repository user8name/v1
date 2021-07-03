# -*- coding: UTF-8 -*-
# pip install PyMySQL xlwt xlrd
import sys
import getopt
import xlwt
import xlrd
import json
import codecs
from collections import defaultdict
from collections import OrderedDict
import pymysql
import re
import os
import shutil
import urllib.error
import urllib.request
from bs4 import BeautifulSoup


def uploadimg(id,db,flagurl):
    cursor = db.cursor()
    #处理图片
    sql = "select imgfile from wp_products_img where productid=%d" % (id)
    cursor.execute(sql)
    imgrow = cursor.fetchall()
    imgs = {}
    for i in range(len(imgrow)):
        imgs[imgrow[i][0]]=''
    
    path = r'C:\Users\suxia\Downloads\原网站上传产品数据-图片\原网站上传产品数据-图片'
    imgflag = flagurl.strip()

    for i in range(20):
        imgflagi2=imgflag+'-'+str(i+1)+'.jpg'
        if imgflagi2.lower() in imgs:
            pass
        else:
            imgfullpath = path+'\\'+imgflagi2
            if os.path.exists(imgfullpath):
                sql="insert into wp_products_img (productid,imgfile) values (%d,'%s')" % (id,imgflagi2)
                cursor.execute(sql)
                db.commit()
                imgs[imgflagi2.lower()]=''

def insertdb(dic, jsontxt, db, results, dics):
    cursor = db.cursor()

    # sys.exit()
    cid = int(dic["cid"])
    des = ''
    if 'Description' in dic:
        des = dic["Description"]
    des = db.escape_string(des)

    mw=''
    if 'molecular weight  g/mol' in dic:
        mw = dic["molecular weight  g/mol"]
    mw = db.escape_string(mw)

    particlesize = ''
    if 'Particle Size' in dic:
        particlesize = dic["Particle Size"]
    particlesize = db.escape_string(particlesize)

    inherentviscosity = ''
    if '(inherent) viscosity' in dic:
        inherentviscosity = dic["(inherent) viscosity"]
    inherentviscosity = db.escape_string(inherentviscosity)

    sql = "INSERT INTO wp_products(cid, \
        cat, productname,particlesize, description,mw,inherentviscosity,detail) \
        VALUES ('%d', '%s', '%s','%s', '%s','%s','%s','%s' )" % \
        (cid, dic["Cat.No."], db.escape_string(dic["Product Name"]), particlesize,des,mw,inherentviscosity, db.escape_string(jsontxt))
    try:
        cursor.execute(sql)
        id = int(db.insert_id())
        sql = "INSERT INTO wp_products_json(productid,jsontxt) \
        VALUES ('%d', '%s' )" % \
            (id, db.escape_string(jsontxt))
        cursor.execute(sql)
        sql = "INSERT INTO wp_products_search(productid,searchtxt) \
        VALUES ('%d', '%s' )" % \
            (id, re.sub(r'["|{|}|,|:|\'|\r|\n|\t]', r'', jsontxt))
        cursor.execute(sql)
        db.commit()

        #uploadimg(id,db,dic["CAT #"])
    except:
        db.rollback()
        print("Unexpected error:", sys.exc_info()[1], sql)

def updatedb(dic, jsontxt, db, results, dics):
    cursor = db.cursor()

    # sys.exit()
    cid = int(dic["cid"])
    des = ''
    if 'Description' in dic:
        des = dic["Description"]
    des = db.escape_string(des)

    mw=''
    if 'molecular weight  g/mol' in dic:
        mw = dic["molecular weight  g/mol"]
    mw = db.escape_string(mw)

    particlesize = ''
    if 'Particle Size' in dic:
        particlesize = dic["Particle Size"]
    particlesize = db.escape_string(particlesize)

    inherentviscosity = ''
    if '(inherent) viscosity' in dic:
        inherentviscosity = dic["(inherent) viscosity"]
    inherentviscosity = db.escape_string(inherentviscosity)

    sql = "select id from wp_products where cat='%s'" % (dic['Cat.No.'])
    cursor.execute(sql)
    data = cursor.fetchone()
    id = data[0]
    #print(id)
    sql = "update wp_products set cid=%d, \
        productname='%s', particlesize='%s',description='%s',mw='%s',inherentviscosity='%s',detail='%s' where id=%d" % \
        (cid, db.escape_string(dic["Product Name"]),particlesize, des, mw,inherentviscosity,db.escape_string(jsontxt), id)
    try:
        cursor.execute(sql)
        #db.commit()
        sql = "update wp_products_json set jsontxt='%s' where productid=%d" % \
            (db.escape_string(jsontxt), id)
        cursor.execute(sql)
        sql = "update wp_products_search set searchtxt='%s' where productid=%d" % \
            (re.sub(r'["|{|}|,|:|\'|\r|\n|\t]', r'', jsontxt), id)
        cursor.execute(sql)
        db.commit()
    except:
        db.rollback()
        print("Unexpected error:", sys.exc_info()[1], sql)

    #uploadimg(id,db,dic["CAT #"])

def moveimg(db):
    sql = 'SELECT imgfile FROM `wp_products_img`'
    cursor = db.cursor()
    cursor.execute(sql)
    results = cursor.fetchall()

    path = r'C:\Users\suxia\Downloads\barco-v2\barco'
    for i in range(len(results)):
        try:
            fullpath = path+'\\'+results[i][0]
            if os.path.exists(fullpath):
                shutil.copyfile(fullpath,path+'\\ok\\'+results[i][0])
            else:
                print(fullpath)
        except:
            print("Unexpected error:", sys.exc_info()[0])

def updateimg(db):
    sql = 'SELECT imgid,imgfile,cat FROM `wp_products_img` inner join wp_products on wp_products_img.productid=wp_products.id'
    cursor = db.cursor()
    cursor.execute(sql)
    results = cursor.fetchall()

    path = r'C:\Users\suxia\Downloads\barco-v2\barco\ok'
    for i in range(len(results)):
        try:
            fullpath = path+'\\'+results[i][1]
            s = results[i][1]
            print(s)
            c = s.rfind('-')
            s = s.replace(s[0:c],results[i][2]).lower()
            print(s)
            fullpath2 = path+'\\'+s
            print(fullpath2)
            if os.path.exists(fullpath):
                pass
                shutil.move(fullpath,fullpath2)
                sql = "update `wp_products_img` set imgfile='%s' where imgfile='%s'" % (s,results[i][1])
                cursor.execute(sql)
                db.commit()
            else:
                print(fullpath)
        except:
            print("Unexpected error:", sys.exc_info()[0])

def downloadimg(db):
    sql = 'SELECT id,cat,detail FROM `wp_products` where id not in(select productid from wp_products_img GROUP by productid)'
    cursor = db.cursor()
    cursor.execute(sql)
    results = cursor.fetchall()
    work_dir=os.path.abspath('.')  
    for i in range(len(results)):
        try:
           pass
           txt = json.loads(results[i][2])
           work_path=os.path.join('D:\\www\\img\\',results[i][1]+'.html')  
           work_path_img=os.path.join('D:\\www\\img\\',results[i][1]+'-1.jpg')  
           sql="insert into wp_products_img (productid,imgfile) values (%d,'%s')" % (int(results[i][0]),results[i][1]+'-1.jpg')
           cursor.execute(sql)
           db.commit()
           print(txt['abs_url'])
           txtstring=''
           if os.path.exists(work_path)!=True:
                req = urllib.request.Request(txt['abs_url'])
                req.add_header('User-Agent','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.96 Safari/537.36')
                with urllib.request.urlopen(req) as f:
                        #print('Status:', f.status, f.reason)
                        #for k, v in f.getheaders():
                        #    print('%s: %s' % (k, v))
                        #print('Data:', f.read().decode('utf-8'))
                        txtstring = f.read().decode('utf-8')
                        file =  codecs.open(work_path, 'w','utf-8') 
                        file.write(txtstring)
                        file.close()
           else:
               file =  codecs.open(work_path, 'r','utf-8') 
               txtstring = file.read()
               file.close()
           pass

           if os.path.exists(work_path_img)!=True:
                soup = BeautifulSoup(txtstring, 'html.parser')  
                #print(soup.prettify())
                imgsource = soup.find('img', {'class':'img-responsive'})
                #print(str(imgsource))
                #print(re.search(r'src="(.*)\?',str(imgsource),re.I|re.S).group(1))
                url = 'http://www.barco.com.cn'+re.sub(' ','%20',re.search(r'src="(.*)\?',str(imgsource),re.I|re.S).group(1))
                print(url)
                urllib.request.urlretrieve(url, work_path_img)   
           



        except:
            print("Unexpected error:", sys.exc_info()[0])
        
        #sys.exit()


def dotask(infile, outfile):
    book = xlwt.Workbook(encoding='utf-8', style_compression=0)
    sheet = book.add_sheet('data', cell_overwrite_ok=True)

    wb = xlrd.open_workbook(infile)
    convert_list = []
    sh = wb.sheet_by_index(0)#从0开始
    title = sh.row_values(0)

    #db = pymysql.connect("cddbmysql.c8qakfd9b1ln.us-west-1.rds.amazonaws.com", "matexcel","bykeos8vFcThfFoR", "matexcel")
    db = pymysql.connect(host="localhost",user="lrj",port=3306,passwd="jb51.net",db="matexcel")
    db.set_charset('utf8')

    #downloadimg(db)
    #moveimg(db)
    #updateimg(db)
    #sys.exit()
    sql = 'SELECT id,name FROM `wp_products_categories`'
    cursor = db.cursor()
    cursor.execute(sql)
    results = cursor.fetchall()

    sql = 'SELECT cat FROM `wp_products`'
    cursor.execute(sql)
    products = cursor.fetchall()

    dics = {}
    for i in range(len(products)):
        dics[products[i][0].lower()] = ''

    #print(len(dics))
    #sys.exit(0)
    for rownum in range(0, sh.nrows):
        rowvalue = sh.row_values(rownum)
        #single = defaultdict()
        single = OrderedDict()

        for colnum in range(0, len(rowvalue)):

            sheet.write(rownum, colnum, rowvalue[colnum])
            if rowvalue[colnum] != '':
                single[title[colnum]] = rowvalue[colnum]

        if rownum == 0:
            sheet.write(rownum, 0, r'json')
        else:
            j = json.dumps(single, skipkeys=False, ensure_ascii=False)

            # sys.exit()
            sheet.write(rownum, 0, j)
            if single["Cat.No."].lower() in dics:
                print('update:'+single["Cat.No."])
                updatedb(single, j, db, results, dics)
            else:
                print('insert:'+single["Cat.No."])
                dics[single["Cat.No."]] = ''
                insertdb(single, j, db, results, dics)

        # convert_list.append(single)

    # j = json.dumps(convert_list)

    # print(j)
    db.close()
    book.save(outfile)

def main(argv):
    #inputfile = r'C:\Users\suxia\Downloads\barco-v2-确定最后上传部分 -命名后编号.xlsx'
    #inputfile = r'/media/sf_Downloads/金属陶瓷&聚合物材料 IT-Log_0705.xls'
    #outputfile = r'/media/sf_Downloads/1.xlsx'

    inputfile = r'D:\ABQ\文档\matexcel\import\Matexcel IT-log，临时包装210605.xlsx'
    outputfile = r'D:\ABQ\文档\matexcel\import\1.xlsx'
    try:
        opts, args = getopt.getopt(argv, "hi:o:", ["ifile=", "ofile="])
    except getopt.GetoptError:
        print('batchtask.py -i <inputfile> -o <outputfile>')
        sys.exit()
    for opt, arg in opts:
        if opt == '-h':
            print('batchtask.py -i <inputfile> -o <outputfile>')
            sys.exit()
        elif opt in ("-i", "--ifile"):
            inputfile = arg
        elif opt in ("-o", "--ofile"):
            outputfile = arg
    print('input file: ', inputfile)
    print('output file: ', outputfile)
    dotask(inputfile, outputfile)


if __name__ == "__main__":
    main(sys.argv[1:])

<?php
include "head.php";
?>
<div class="grid1">

    <div class="banner1">
        <img class="logo" src="../img/saintmed_logo.png"></img>
    </div>
<p id ="headr2">โครงการที่ทำ Requisition แล้ว รออนุมัติ</p>
<p id ="reader">โครงการทั้งหมดที่มีการทำ requisition แล้ว โดยพนักงานขายแต่ละคนทำ requisition เข้ามาให้ตรวจ รายการเหล่านี้ยังไม่ได้รับการอนุมัติจากผู้จัดการ <a href="http://saintmed.dyndns.biz/tenders/tender_list3x.asp?">ดูโครงการที่ยังไม่มี requisition</a></p>
                    <?php
                        include "connect.php";  // Using database connection file here
                        $query = "WITH contact1 AS
                                  (
                                    SELECT contact.client_id_fk,contact.company_Name, 
                                      rn = ROW_NUMBER() OVER 
                                      (
                                          PARTITION BY contact.client_id_fk
                                          ORDER BY contact.client_id_fk
                                      )
                                    FROM contact 
                                  )
                                  SELECT projects.ID, projects.project_desc, projects.project_code1, projects.qt_date, projects.tender_date, projects.flag_date, projects.result_date, projects.sign_date, projects.tender_code, projects.announ_code, projects.budget, projects.pro_value , projects.client_id_fk, projects.pcode, projects.date_created, projects.org_id_fk, projects.employee_id_fk, projects.waran, projects.onsite_within, projects.notes, projects.delidate, projects.spt_note, projects.delitime, projects.status, projects.modified_by, projects.modifiedDate, projects.createdDate, projects.unitprice, projects.unitnum, projects.employee, projects.cl, projects.kb_des, projects.kb_des2, projects.kb_value, projects.kb_value2, projects.req_id,contact1.company_Name,status.sid,status.sinfo
                                  FROM req 
                                  LEFT JOIN projects ON req.project_id_fk = projects.ID 
                                  LEFT JOIN contact1 ON projects.client_id_fk = contact1.client_id_fk
                                  LEFT JOIN status ON projects.status = status.sid
                                  WHERE rn = 1 and projects.status<>9 
                                  GROUP BY projects.ID, projects.project_desc, projects.project_code1, projects.qt_date, projects.tender_date, projects.flag_date, projects.result_date, projects.sign_date, projects.tender_code, projects.announ_code, projects.budget, projects.pro_value, projects.client_id_fk, projects.pcode, projects.date_created, projects.org_id_fk, projects.employee_id_fk, projects.waran, projects.onsite_within, projects.notes, projects.delidate, projects.spt_note, projects.delitime, projects.status, projects.modified_by, projects.modifiedDate, projects.createdDate, projects.unitprice, projects.unitnum, projects.employee, projects.cl, projects.kb_des, projects.kb_des2, projects.kb_value, projects.kb_value2, projects.pcode, projects.req_id,contact1.company_Name,status.sid,status.sinfo
                                  ORDER BY projects.ID ASC
                                  ";
                        $stmt = $conn->query( $query );

                        if( $conn->query( $query ) ){
                            if (empty($_GET)) {
                            echo "<table class='table_h' >
                            <tr>
                            <th>รหัสโครงการ</th>
                            <th>วันที่ในสัญญา</th>
                            <th>โรงพยาบาล</th>
                            <th>ประกาศ <br> ประกวดราคา</th>
                            <th>เลขที่สัญญา</th>
                            <th>งบกลาง</th>
                            <th>ราคาต่อเครื่อง</th>
                            <th>จำนวน</th>
                            <th>ราคารวม VAT</th>
                            <th>ส่งมอบ</th>
                            <th>สถานะ</th>
                            <th>Edit</th>
                            </tr>";

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    echo "<td style= width:7%;><a href=\"view_req.php?ID=".$row['ID']."&PID=".$row['project_code1']."\">". $row['project_code1'] ."</td>";
                                    echo "<td style= width:8.5%;>". $row['sign_date'] ."</td>";

                                    echo "<td style= width:25%;><a href=\"req.php?com=".$row['client_id_fk']."\">"
                                    .$row['company_Name']."</a>"."<br>".$row['project_desc'];
                                     "</td>";

                                    echo "<td style= width:8.5%;>". $row['announ_code'] ."<br>".$row['tender_code']."</td>";
                                    echo "<td>". $row['pcode'] ."</td>";
                                    echo "<td style= width:6%;>". number_format($row['budget']) ."</td>";
                                    echo "<td>". number_format($row['unitprice']) ."</td>";
                                    echo "<td>". $row['unitnum'] ."</td>";
                                    echo "<td style= width:8%;>". number_format($row['pro_value']) ."</td>";
                                    echo "<td>". $row['delitime'] ."</td>";
                                    echo "<td>". $row['sinfo'] ."</td>";
                                    echo "<td style= width:4%;><a href=\"view_req.php?ID=".$row['ID']."&PID=".$row['project_code1']."\"> edit </a></td>";
                                echo "</tr>";
                            } 

                        echo "</table>";
                        }       
                        else if($_GET['com'] ){
                                include "connect.php";
                                $query3 = "WITH contact1 AS
                                  (
                                    SELECT contact.client_id_fk,contact.company_Name, 
                                      rn = ROW_NUMBER() OVER 
                                      (
                                          PARTITION BY contact.client_id_fk
                                          ORDER BY contact.client_id_fk
                                      )
                                    FROM contact 
                                  )
                                    SELECT projects.ID, projects.project_code1, projects.sign_date, contact1.company_Name, projects.project_desc, projects.announ_code, projects.tender_code, projects.pcode,projects.budget, projects.unitprice, projects.unitnum, projects.pro_value , projects.delitime,projects.req_id,projects.client_id_fk
                                    FROM projects 
                                    LEFT JOIN contact1 ON projects.client_id_fk = contact1.client_id_fk
                                    WHERE projects.client_id_fk = ".$_GET['com']." and contact1.rn = 1
                                  ";
                        $stmt3 = $conn->query( $query3 );

                        if( $conn->query( $query3 ) ){
                                

                            echo "<table class='table_h' >
                            <tr>
                            <th>รหัสโครงการ</th>
                            <th>วันที่ในสัญญา</th>
                            <th>โรงพยาบาล</th>
                            <th>ประกาศ <br> ประกวดราคา</th>
                            <th>เลขที่สัญญา</th>
                            <th>งบกลาง</th>
                            <th>ราคาต่อเครื่อง</th>
                            <th>จำนวน</th>
                            <th>ราคารวม VAT</th>
                            <th>ส่งมอบ</th>
                            <th>สถานะ</th>
                            <th>Edit</th>
                            </tr>";

                            while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)){
                                    echo "<td style= width:7%;><a href=\"view_req.php?ID=".$row['ID']."\">". $row['project_code1'] ."</td>";
                                    echo "<td style= width:8.5%;>". $row['sign_date'] ."</td>";

                                    echo "<td style= width:25%;><a href=\"req.php?com=".$row['client_id_fk']."\">"
                                    .$row['company_Name']."</a>"."<br>".$row['project_desc'];
                                     "</td>";

                                    echo "<td style= width:8.5%;>". $row['announ_code'] ."<br>".$row['tender_code']."</td>";
                                    echo "<td>". $row['pcode'] ."</td>";
                                    echo "<td style= width:6%;>". number_format($row['budget']) ."</td>";
                                    echo "<td>". number_format($row['unitprice']) ."</td>";
                                    echo "<td>". $row['unitnum'] ."</td>";
                                    echo "<td style= width:8%;>". number_format($row['pro_value']) ."</td>";
                                    echo "<td>". $row['delitime'] ."</td>";
                                    echo "<td>". $row['req_id'] ."</td>";
                                    echo "<td style= width:4%;><a href=\"view_req.php?ID=".$row['ID']."\"> edit </a></td>";
                                echo "</tr>";
                            }
							

                        echo "</table>";
                        }

                    }}
                            
                                if (empty($_GET)) {
                                $query = "WITH ss AS
                                            (
                                             SELECT req.project_id_fk,projects.pro_value FROM req 
                                              INNER JOIN projects ON req.project_id_fk = projects.ID 
                                                where projects.status <> 9
                                                group by req.project_id_fk,projects.pro_value
                                            )
                                             select sum(try_convert(decimal(38, 2), pro_value)) as pro_value from ss
                                          ";
                                $stmt = $conn->query( $query );

                                echo "<table class='table_sum' >

                                <tr>
                                <th>โครงการทั้งหมด</th>
                                <th>โครงการที่ได้</th>
                                <th>โครงการที่ไม่ทราบสถานะ</th>
                                <th>ไม่ได้โครงการ</th>
                                </tr>";

                                while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<td><h3>". number_format($row2['pro_value'],2) ."</h3></td>";
                                echo "<td><h3>". '0.00' ."</h3></td>";
                                echo "<td><h3>". '0.00' ."</h3></td>";
                                echo "<td><h3>". number_format($row2['pro_value'],2) ."</h3></td>";

                                echo "</tr>";
                                    }
                                echo "</table>";
                                }

                                else if($_GET['com'] ){
                                $query = "SELECT sum(try_convert(decimal(38, 2), pro_value)) as pro_value 
                                          FROM projects
                                          WHERE client_id_fk LIKE '%".$_GET['com']."%' 

                                          ";
                                $stmt = $conn->query( $query );
                                echo "<table class='table_sum' >
                                <tr>
                                <th>โครงการทั้งหมด</th>
                                <th>โครงการที่ได้</th>
                                <th>โครงการที่ไม่ทราบสถานะ</th>
                                <th>ไม่ได้โครงการ</th>
                                </tr>";

                                while ($row3 = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<td><h3>". number_format($row3['pro_value'],2) ."</h3></td>";
                                echo "<td><h3>". '0.00' ."</h3></td>";
                                echo "<td><h3>". '0.00' ."</h3></td>";
                                }
                                $query2 = "SELECT  sum(try_convert(decimal(38, 2), pro_value)) as pro_value2  from projects where projects.client_id_fk LIKE '%".$_GET['com']."%' and projects.status <> 9
                                          ";
                                $stmt2 = $conn->query( $query2 );
                                while ($row4 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                    echo "<td><h3>". number_format($row4['pro_value2'],2) ."</h3></td>";
                                

                                echo "</tr>";
                                    }
                                echo "</table>";
                                }    
                        
                    ?>


                    <p id ="headr">โครงการที่สิ้นสุดไปแล้ว ส่งของ หรือวางบิลแล้ว</p>
                    <div class="table_st">
                    <?php
                        include "connect.php";  // Using database connection file here
                        $query = "WITH contact1 AS
                                  (
                                    SELECT contact.client_id_fk,contact.company_Name, 
                                      rn = ROW_NUMBER() OVER 
                                      (
                                          PARTITION BY contact.client_id_fk
                                          ORDER BY contact.client_id_fk
                                      )
                                    FROM contact 
                                  )
                                  SELECT projects.ID, projects.project_desc, projects.project_code1, projects.qt_date, projects.tender_date, projects.flag_date, projects.result_date, projects.sign_date, projects.tender_code, projects.announ_code, CAST(projects.budget AS decimal(38,0)) as budget, CAST(projects.pro_value AS decimal(38,0)) as pro_value , projects.client_id_fk, projects.pcode, projects.date_created, projects.org_id_fk, projects.employee_id_fk, projects.waran, projects.onsite_within, projects.notes, projects.delidate, projects.spt_note, projects.delitime, projects.status, projects.modified_by, projects.modifiedDate, projects.createdDate, projects.unitprice, projects.unitnum, projects.employee, projects.cl, projects.kb_des, projects.kb_des2, projects.kb_value, projects.kb_value2, projects.req_id,contact1.company_Name
                                  FROM req INNER JOIN projects ON req.project_id_fk = projects.ID 
                                  LEFT JOIN contact1 ON projects.client_id_fk = contact1.client_id_fk
                                  WHERE rn = 1
                                  GROUP BY projects.ID, projects.project_desc, projects.project_code1, projects.qt_date, projects.tender_date, projects.flag_date, projects.result_date, projects.sign_date, projects.tender_code, projects.announ_code, projects.budget, projects.pro_value, projects.client_id_fk, projects.pcode, projects.date_created, projects.org_id_fk, projects.employee_id_fk, projects.waran, projects.onsite_within, projects.notes, projects.delidate, projects.spt_note, projects.delitime, projects.status, projects.modified_by, projects.modifiedDate, projects.createdDate, projects.unitprice, projects.unitnum, projects.employee, projects.cl, projects.kb_des, projects.kb_des2, projects.kb_value, projects.kb_value2, projects.pcode, projects.req_id,contact1.company_Name
                                  HAVING (((projects.status)=9)) 
                                  ORDER BY projects.ID ASC ";
                        $stmt = $conn->query( $query );


                        if( $conn->query( $query ) ){
                           echo "<table border='1'>
                        <tr>
                        <th>รหัสโครงการ</th>
                        <th>วันที่ในสัญญา</th>
                        <th>โรงพยาบาล</th>
                        <th>ประกาศ <br> ประกวดราคา</th>
                        <th>เลขที่สัญญา</th>
                        <th>งบกลาง</th>
                        <th>ราคาต่อเครื่อง</th>
                        <th>จำนวน</th>
                        <th>ราคารวม VAT</th>
                        <th>ส่งมอบ</th>
                        <th>Edit</th>
                        </tr>";

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            echo "<tr>";
                                echo "<td style= width:7%;><a href=\"view_req.php?ID=".$row['ID']."\">". $row['project_code1'] ."</td>";
                                echo "<td style= width:8.5%;>". $row['sign_date'] ."</td>";

                                echo "<td style= width:25%;><a href=\"req.php?com=".$row['client_id_fk']."\">"
                                .$row['company_Name']."</a>"."<br>".$row['project_desc'];
                                 "</td>";

                                echo "<td>". $row['announ_code'] ."<br>".$row['tender_code']."</td>";
                                echo "<td>". $row['pcode'] ."</td>";
                                echo "<td style= width:6%;>". number_format($row['budget']) ."</td>";
                                echo "<td>". number_format($row['unitprice']) ."</td>";
                                echo "<td>". $row['unitnum'] ."</td>";
                                echo "<td>". number_format($row['pro_value']) ."</td>";
                                echo "<td>". $row['delitime'] ."</td>";
                                echo "<td style= width:4%;><a href=\"view_req.php?ID=".$row['ID']."\"> edit </a></td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                        }

                                $querys = "WITH aa AS
                                            (
                                             SELECT req.project_id_fk,projects.pro_value FROM req 
                                              INNER JOIN projects ON req.project_id_fk = projects.ID 
                                                where projects.status = 9
                                                group by req.project_id_fk,projects.pro_value
                                            )
                                             select sum(try_convert(decimal(38, 2), pro_value)) as pro_value from aa
                                          ";
                                $stmt = $conn->query( $querys );
                                
                                echo "<table class='table_sum' >

                                <tr>
                                <th>โครงการทั้งหมด</th>
                                <th>โครงการที่ได้</th>
                                <th>โครงการที่ไม่ทราบสถานะ</th>
                                <th>ไม่ได้โครงการ</th>
                                </tr>";

                                while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<td><h3>". number_format($row2['pro_value'],2) ."</h3></td>";
                                echo "<td><h3>". '0.00' ."</h3></td>";
                                echo "<td><h3>". '0.00' ."</h3></td>";
                                echo "<td><h3>". '0.00' ."</h3></td>";

                                echo "</tr>";
                                    }
                                echo "</table>";
                                
                    ?>
                </div>
</div>
     <div class="footer">ลิขสิทธิ์ถูกต้อง © 2021 บริษัท เซนต์เมด จำกัด (มหาชน)</div>  
 
</body>
</html> 


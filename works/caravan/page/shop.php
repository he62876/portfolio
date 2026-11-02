<?php include('../lib/header.php');?>
<div class="container">
    <h1>편의마켓 입점신청</h1>
    <p style="text-align: center">신청 검토 기간은 2 ~ 3일 정도 소요되며, 담당자가 안내전화를 드립니다.</p></br>
    <form action="">
        <table class="table info-table">
            <tr>
                <th class="table-light">업체명</th>
                <td>
                    <input type="text" placeholder="이름을 입력하세요">
                </td>
            </tr>
            <tr>
                <th class="table-light">대표자명</th>
                <td>
                    <input type="text" placeholder="대표자명을 입력하세요">
                </td>
            </tr>
            <tr>
                <th class="table-light">주소</th>
                <td>
                    <input type="text" placeholder="주소를 입력하세요">
                </td>
            </tr>
            <tr>
                <th class="table-light">연락처</th>
                <td>
                    <input type="text" placeholder="연락처를 입력하세요">
                </td>
            </tr>
            <tr>
                <th class="table-light">사업자등록증</th>
                <td>
                    <input type="file" >
                </td>
            </tr>
            <tr>
                <th class="table-light">영업신고증</th>
                <td>
                    <input type="file" >
                </td>
            </tr>
            <tr>
                <th class="table-light">업체이미지</th>
                <td>
                    <input type="file" >
                </td>
            </tr>
        </table>
        <div class="d-flex justify-content-between">
            <div>
                <input type="checkbox" id="ck"><label for="ck">개인정보수집에 동의합니다</label>
            </div>
            <a href="">약관보기</a>
        </div>
        <button>신청하기</button>
    </form>
</div>
<?php include('../lib/footer.php');?>
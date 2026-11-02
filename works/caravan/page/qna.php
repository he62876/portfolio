<?php include('../lib/header.php');?>
<div class="container">
    <h1>문의하기</h1>
    <form action="">
        <table class="table info-table">
            <tr>
                <th class="table-light">이름</th>
                <td>
                    <input type="text" placeholder="이름을 입력하세요">
                </td>
            </tr>
            <tr>
                <th class="table-light">연락처</th>
                <td>
                    <input type="text" placeholder="연락처를 입력하세요">
                </td>
            </tr>
            <tr>
                <th class="table-light">이메일</th>
                <td>
                    <input type="text" placeholder="이메일을 입력하세요">
                </td>
            </tr>
            <tr>
                <th class="table-light">문의종류</th>
                <td>
                    <select name="" id="">
                        <option value="">카라반매매/거래</option>
                        <option value="">카라반투자</option>
                        <option value="">제휴문의</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="table-light">문의내용</th>
                <td>
                    <textarea name="" id="" cols="30" rows="10" placeholder="문의내용을 입력하세요"></textarea>
                </td>
            </tr>
        </table>
        <div class="d-flex justify-content-between">
            <div>
                <input type="checkbox" id="ck"><label for="ck">개인정보수집에 동의합니다</label>
            </div>
            <a href="">약관보기</a>
        </div>
        <button>문의하기</button>
    </form>
</div>
<?php include('../lib/footer.php');?>
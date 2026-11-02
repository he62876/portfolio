<?php include('../lib/header.php');?>
<style>
    .cate-list {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .cate-list input {
        display: none;
    }
    .cate-list label {
        cursor: pointer;
        padding: 10px 20px;
        margin: 5px;
        border-radius: 20px;
        border: 1px solid #e7e7e6;
        white-space: nowrap;
    }

    .cate-list input:checked + label {
        background: #3e3e38;
        color: #fff;
        border-color: #3e3e38;
    }

    .faq-list {
        border-top: 2px solid #3e3e38;
        border-bottom: 2px solid #3e3e38;
        margin-top: 20px;
    }
    .sub {
        cursor: pointer;
        border-top: 1px solid #3e3e38;
        border-bottom: 1px solid #e7e7e6;
        padding: 15px 20px;
    }
    .cont {
        background: #f7f7f7;
        padding: 15px 40px;
    }
</style>
<div class="container">
    <h1>FAQ</h1>
    <div class="cate-list">
        <input type="radio" name="category" id="cate0" checked><label for="cate0">전체</label>
        <input type="radio" name="category" id="cate1"><label for="cate1">회원가입</label>
        <input type="radio" name="category" id="cate2"><label for="cate2">예약방법</label>
        <input type="radio" name="category" id="cate3"><label for="cate3">서비스이용</label>
        <input type="radio" name="category" id="cate4"><label for="cate4">카라반</label>
        <input type="radio" name="category" id="cate5"><label for="cate5">편의마켓</label>
        <input type="radio" name="category" id="cate6"><label for="cate6">옵션</label>
        <input type="radio" name="category" id="cate7"><label for="cate7">결제관련</label>
        <input type="radio" name="category" id="cate8"><label for="cate8">환불 및 예약취소</label>
    </div>
    <ul class="faq-list">
        <li>
            <div class="sub">
                <span>회원가입</span>
                <p style="display: inline-block; margin-left: 20px;">회원가입은 어떻게 하나요?</p>
            </div>
            <div class="cont">
                <p>답변입니다.</p>
            </div>
        </li>
        <li>
            <div class="sub">
                <span>회원가입</span>
                <p style="display: inline-block; margin-left: 20px;">회원가입은 어떻게 하나요?</p>
            </div>
            <div class="cont">
                <p>답변입니다.</p>
            </div>
        </li>
        <li>
            <div class="sub">
                <span>회원가입</span>
                <p style="display: inline-block; margin-left: 20px;">회원가입은 어떻게 하나요?</p>
            </div>
            <div class="cont">
                <p>답변입니다.</p>
            </div>
        </li>
        <li>
            <div class="sub">
                <span>회원가입</span>
                <p style="display: inline-block; margin-left: 20px;">회원가입은 어떻게 하나요?</p>
            </div>
            <div class="cont">
                <p>답변입니다.</p>
            </div>
        </li>
        <li>
            <div class="sub">
                <span>회원가입</span>
                <p style="display: inline-block; margin-left: 20px;">회원가입은 어떻게 하나요?</p>
            </div>
            <div class="cont">
                <p>답변입니다.</p>
            </div>
        </li>
        <li>
            <div class="sub">
                <span>회원가입</span>
                <p style="display: inline-block; margin-left: 20px;">회원가입은 어떻게 하나요?</p>
            </div>
            <div class="cont">
                <p>답변입니다.</p>
            </div>
        </li>
        <li>
            <div class="sub">
                <span>회원가입</span>
                <p style="display: inline-block; margin-left: 20px;">회원가입은 어떻게 하나요?</p>
            </div>
            <div class="cont">
                <p>답변입니다.</p>
            </div>
        </li>
    </ul>
</div>
<?php include('../lib/footer.php');?>
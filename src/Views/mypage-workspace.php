<!-- Unique -->
<link rel="stylesheet" href="/css/workspace.css">

<aside class="py-3">
    <div id="tools" class="mt-5">
        <h5 class="title text-white font-weight-bold text-center">도구</h5>
        <div class="list stack mt-4">
            <div class="tool active" data-key="pen">펜</div>
            <div class="tool" data-key="curve">곡선</div>
            <div class="tool" data-key="figure">도형</div>
            <div class="tool" data-key="compass">컴퍼스</div>
            <div class="tool" data-key="ruler">자</div>
            <div class="tool" data-key="fill">채우기</div>
            <div class="tool" data-key="eraser">지우개</div>
        </div>
    </div>
    <hr>
    <div id="options">
        <h5 class="title text-white font-weight-bold text-center">옵션</h5>
        <div class="list d-flex flex-column mt-4 px-3">
        </div>
    </div>
    <div class="px-2">
        <button id="download" class="fill-btn">다운로드</button>
    </div>
</aside>

<div id="main-canvas">
</div>

<div id="colorPicker" style="display: none;">
    <div class="main">
        <canvas class="picker" width="300" height="270" data-name="main" data-context="mctx"></canvas>
    </div>
    <div class="sub">
        <canvas class="picker" width="25" height="270" data-name="sub" data-context="sctx"></canvas>
    </div>
    <div class="opacity">
        <canvas class="picker" width="25" height="270" data-name="opacity" data-context="octx"></canvas>
    </div>
</div>

<!-- 색 선택 -->
<script src="/js/workspace/ColorPicker.js"></script>

<!-- 그리기용 코드 -->
<script src="/js/workspace/Tool.js"></script>
<script src="/js/workspace/Pen.js"></script>
<script src="/js/workspace/Curve.js"></script>
<script src="/js/workspace/Figure.js"></script>
<script src="/js/workspace/Compass.js"></script>
<script src="/js/workspace/Ruler.js"></script>
<script src="/js/wrokspace/Fill.js"></script>
<script src="/js/workspace/Eraser.js"></script>
<script src="/js/workspace/Canvas.js"></script>
<script src="/js/workspace/App.js"></script>


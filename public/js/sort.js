/**
 * 커스텀 기준 정렬
 * [한글 - 영문 (대소문자 구분 x) - 숫자 - 그 외]
 */

 
String.prototype.isHangle = function(){
    return /[ㄱ-ㅎㅏ-ㅣ가-힣]/.test(this);
}
String.prototype.isNumber = function(){
    return /[0-9]/.test(this);
}
String.prototype.isEnglish = function(){
    return /[a-zA-Z]/.test(this);
}
String.prototype.isCommon = function(){
    return /[a-zA-Z0-9ㄱ-ㅎㅏㅣ가-힣]/.test(this);
};

Array.prototype.customSort = function(key = ""){
    return this.sort((A, B) => {
        if(key !== "") {
            A = A[key];
            B = B[key];
        }

        let s_length = A.length > B.length ? B.length : A.length; // 제일 작은 크기만큼 돌림
        for(let i = 0; i < s_length; i++){
            // 각 문자에서 N번째 문자를 꺼내옴
            let a = A[i];
            let b = B[i];

            // 제외 문자 최후방
            if(a.isCommon() && !b.isCommon()) return -1;
            if(!a.isCommon() && b.isCommon()) return 1;

            // 한글 최우선
            if(a.isHangle() || b.isHangle()) {
                if(a.isHangle() && !b.isHangle()) return -1;
                else if(!a.isHangle() && b.isHangle()) return 1;
                // 둘다 한글일 때
                else {
                    let compare = a.localeCompare(b);
                    if(compare === 0) continue; // 우선 순위가 같다면 다음 글자를 검사
                    else return compare; // 아니라면 해당 순서 반환
                }
            }

            // 영문 차선
            if(a.isEnglish() || b.isEnglish()) {
                if(a.isEnglish() && !b.isEnglish()) return -1;
                else if(!a.isEnglish() && b.isEnglish()) return 1;
                // 둘다 영문일 때
                else {
                    let compare = a.localeCompare(b);
                    if(compare === 0) continue; // 우선 순위가 같다면 다음 글자를 검사
                    else return compare; // 아니라면 해당 순서 반환
                }
            }

            let compare = a.localeCompare(b);
            if(compare === 0) continue; // 우선 순위가 같다면 다음 글자를 검사
            else return compare; // 아니라면 해당 순서 반환
        }

        // 문자가 끝까지 다 돌아가는 동안 글자가 모두 일치했음
        if(A.length === B.length) return 0;
        else return B.length - A.length; // 더 길이가 짧은쪽이 앞으로
    }); 
}
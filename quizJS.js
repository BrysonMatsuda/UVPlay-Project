class QuizController{
    constructor(){
        this.question = "";
        this.answers = [];

        this.currentAnswersLeft=[]; //helps keep track of what has already been guessed
    }

    processGuess(guess){ 

        if(this.currentAnswersLeft.includes(guess)){//this guess is right
            $('td').each(function() {
                console.log("Text: " + $(this).text());

                if($(this).text() == ""){
                    $(this).text(guess);
                    return false;
                }
            });

            this.currentAnswersLeft = this.currentAnswersLeft.filter(item => item != guess);

            $('#inputBox').val("");
        }

        
    
    }

    buildTable(){

        let $table = $("#gameTable");
        $table.empty();

        let $row = "";

        for(let i=0; i < this.answers.length; i++){
            
            console.log(i);
            if(i % 4 == 0){
                $row = $('<tr></tr>');
            }
            let $cell = $("<td></td>");

            $row.append($cell);

            if((i+1) % 4 == 0){
                $table.append($row);
                $row = "";
                console.log("i % 3 0");
            }
        }

        if($row != ""){
            $table.append($row);
        }
        
    }
}



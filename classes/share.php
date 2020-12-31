<?php

class Share{

    public function generateFacebookShareLink(){
        $part_1 = 'http://www.facebook.com/sharer.php?u=';
        
        $url = $this->getCurrentPageUrl();
        return $part_1 . $url; 
    }

    public function generateTwitterShareLink(){
        $part_1 = 'http://twitter.com/share?url=';

        $url = $this->getCurrentPageUrl();
        
        return $part_1 . $url; 
    }

    public function generateEmailShareLink(){
        $part_1 = 'mailto:?Subject=Article Recommendation For You&Body=I%20hope%20you%20will%20enjoy%20this%20article!%20 ';
        $url = $this->getCurrentPageUrl();
        
        return $part_1 . $url; 
    }

    public function generateLinkedInShareLink(){
        $part_1 = 'http://www.linkedin.com/shareArticle?mini=true&url=';
        $url = $this->getCurrentPageUrl();
        
        return $part_1 . $url; 
    }

    private function getCurrentPageUrl(){
        // Current page URL with GET parameters
        $url = $_SERVER['HTTP_REFERER'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    public function getShareButtonTemplate(){
        $template = '
            <div class=social-buttons>
                <b>Share: </b>
                <a href="'.$this->generateFacebookShareLink().'" target="_blank"><i class="fab fa-facebook-square"></i></a>
                <a href="'.$this->generateTwitterShareLink().'" target="_blank"><i class="fab fa-twitter-square"></i></a>
                <a href="'.$this->generateLinkedInShareLink().'" target="_blank"><i class="fab fa-linkedin"></i></a>
                <a href="'.$this->generateEmailShareLink().'" target="_blank"><i class="fas fa-envelope"></i></a>
            </div>
        ';

        return $template;
    }
}

?>
<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\View;

use App\Model\WebSite;
use App\Model\Session;

class News {
    
    /**
     * @param string $url
     * @return void
     */
    public function showArticle(string $url): void {
        
        // get all the required data
        $status = \App\Controller\Web\Status::getAll();
        $article = \App\Controller\Web\Article::getArticleByUrl($url);
        
        if ($article == null) {
            $view = new Error404();
            $view->show();
            exit;
        }

        // render the template and show the result
        echo WebSite::getTemplate()->render(
                'news/single.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'article' => $article,
                    'status' => $status
                ]
        );
        
    }
    
}

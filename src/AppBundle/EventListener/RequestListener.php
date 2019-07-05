<?php


namespace AppBundle\EventListener;

use AppBundle\Entity\Stats;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;

class RequestListener
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $session = $event->getRequest()->getSession();
        if(!$session->get('old')){
            $session->set('old',1);

            $this->em->getRepository(Stats::class)->save([
                'ip'=>$this->getUserIpAddr(),
                'browse'=>$this->getUserBrowser()
            ]);
        }
    }

    public function  getUserIpAddr(){

        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function getUserBrowser()
    {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
            return 'Internet explorer';
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
            return 'Internet explorer';
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
            return 'Firefox';
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
            return 'Chrome';
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
            return "Opera Mini";
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
            return "Opera";
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
            return "Safari";
        else
            return 'Something else';
    }
}

<?php

namespace Tony\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Tony\MainBundle\Entity\Enquiry;
use Tony\MainBundle\Entity\Company;
use Tony\MainBundle\Entity\Comment;
use Tony\MainBundle\Form\EnquiryType;
use Tony\MainBundle\Form\CommentType;

class PageController extends Controller
{
    public function homeAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $listings = $em->getRepository('TonyMainBundle:Company')
            ->getLatestLists(6);

        return $this->render('TonyMainBundle:Pages:home.html.twig', array('listings'=>$listings));
    }

    public function listingAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $listings = $em->getRepository('TonyMainBundle:Company')
            ->getLatestLists();

        return $this->render('TonyMainBundle:Pages:listing.html.twig', array('listings'=>$listings));
    }


    public function contactAction()
    {
        //return $this->render('TonyMainBundle:Pages:contact.html.twig');
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->get('request_stack')->getCurrentRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from Co.Grade')
                    ->setFrom('info@csudo.com')
                    ->setTo($this->container->getParameter('tony.emails.contact_email'))
                    ->setBody($this->renderView('TonyMainBundle:Pages:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add('success', 'Your contact enquiry was successfully sent. Thank you!');

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('tony_main_contact'));
            }
        }

        return $this->render('TonyMainBundle:Pages:contact.html.twig', array(
                'form' => $form->createView()
            ));

    }


    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $company = $em->getRepository('TonyMainBundle:Company')->find($id);
        if (!$company) {
            throw $this->createNotFoundException('Unable to find company list.');
        }

        $comments = $em->getRepository('TonyMainBundle:Comment')
                    ->getCompanyComments($company->getId());

        return $this->render('TonyMainBundle:Pages:show.html.twig', array(
                'company'      => $company,
                'comments'  => $comments
            ));
    }


    public function newAction($id)
    {
        $company = $this->getCompany($id);

        $comment = new Comment();
        $comment->setCompany($company);
        $form   = $this->createForm(new CommentType(), $comment);

        return $this->render('TonyMainBundle:Pages:comment_form.html.twig', array(
                'comment' => $comment,
                'form'   => $form->createView()
            ));
    }

    public function createAction($id)
    {
        $company = $this->getCompany($id);

        $comment  = new Comment();
        $comment->setCompany($company);
        $request = $this->get('request_stack')->getCurrentRequest();
        $form    = $this->createForm(new CommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('tony_main_company_show', array(
                        'id' => $comment->getCompany()->getId())) .
                '#comment-' . $comment->getId()
            );
        }

        return $this->render('TonyMainBundle:Pages:create.html.twig', array(
                'comment' => $comment,
                'form'    => $form->createView()
            ));
    }


    public function sidebarAction()
    {
        $commentLimit   = $this->container
            ->getParameter('latest_comment_limit');
        $em = $this->getDoctrine()->getManager();
        $latestComments = $em->getRepository('TonyMainBundle:Comment')
            ->getLatestComments($commentLimit);

        return $this->render('TonyMainBundle:Pages:sidebar.html.twig', array(
                'latestComments'    => $latestComments
            ));
    }



    protected function getCompany($id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TonyMainBundle:Company')->find($id);

        if (!$company) {
            throw $this->createNotFoundException('Unable to find company list.');
        }

        return $company;
    }


    public function jobsAction($page)
    {

        $rss = new \DOMDocument();
        $rss->load($this->container->getParameter('tamago_feed_render.url'));
        $feed = array();
        foreach ($rss->getElementsByTagName('item') as $node) {
            $item = array (
                'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
            );
            array_push($feed, $item);
        }

        $adapter = new ArrayAdapter($feed);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setCurrentPage($page);
        $pagerfanta->setMaxPerPage($this->container->getParameter('tamago_feed_render.max_per_page'));



        return $this->render('TonyMainBundle:Pages:jobs.html.twig', array('pagerfanta'=>$pagerfanta,));
    }



    public function adminAction()
    {
        return $this->render('TonyMainBundle:Pages:admin.html.twig');
    }

    public function accountAction()
    {
        return $this->render('TonyMainBundle:Pages:account.html.twig');
    }


}
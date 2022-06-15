<?php

namespace App\Controller\Admin;

use App\Classes\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Préparation en cours', 'fas fa-box-open')->linkToCrudAction('updatePreparation');
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours', 'fas fa-truck')->linkToCrudAction('updateDelivery');
        return $actions
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->add('index', 'detail');
    }

    public function updatePreparation(AdminContext $adminContext)
    {
        $order = $adminContext->getEntity()->getInstance();
        $order->setState(2);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span class = 'text-success'> La commande ".$order->getReference()." est bien en cours de préparation </span>");

        $url=$this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        return $this->redirect($url);

        $mail = new Mail();
        $content = "Bonjour, ". $order->getUser()->getFirstname()." <br> nous sommes ravies de vous annoncer que votre commande est en cours de Préparation";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'En cours de Préparation', $content);
    }

    public function updateDelivery(AdminContext $adminContext)
    {
        $order = $adminContext->getEntity()->getInstance();
        $order->setState(3);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span class = 'text-success'> La commande ".$order->getReference()." est bien en cours de Livraison </span>");

        $url=$this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        return $this->redirect($url);

        $mail = new Mail();
        $content = "Bonjour, ". $order->getUser()->getFirstname()." <br> nous sommes ravies de vous annoncer que votre commande est en cours de Livraison";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'En cours de Livraison', $content);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            DateTimeField::new('createdAt', 'Créé le'),
            TextField::new('user.getIdentity', 'Utilisateur'),            
            TextEditorField::new('delivery', 'adresse de livraison')->formatValue(
                function ($value) {
                    return $value;
                }
            )->onlyOnDetail(),
            MoneyField::new('total')->setCurrency('EUR'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),            
            TextField::new('carrierName', 'Transporteur'),
            ChoiceField::new('state')->setChoices(
                [ 
                'Non Payée' => 0,
                'Payée' => 1,
                "En Préparation" =>2,
                "Livraison" => 3
                ]
            ),
        ];
    }

}

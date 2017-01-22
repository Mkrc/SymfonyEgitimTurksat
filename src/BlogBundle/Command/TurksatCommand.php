<?php

namespace BlogBundle\Command;

use BlogBundle\Entity\BlogPost;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class TurksatCommand
 * @package BlogBundle\Command
 *
 * Classın içinde container'a ulasmak istiyorsak ContainerAwareCommand classına extend oluyoruz.
 * Normal commandlarda ise Command classına extend olmamız yeterlidir.
 *
 */
class TurksatCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('turksat:test')
            ->setDescription('Turksat Command')
            ->addArgument("title")
            ->addOption(
                'content',
                null,
                InputOption::VALUE_REQUIRED,
                'How many times should the message be printed?'
            )
            ->setHelp("Turksat Command")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $style = new OutputFormatterStyle('yellow', 'white', array('bold', 'blink'));
        $output->getFormatter()->setStyle('fire', $style);

        /** @var $em EntityManager $em */
        $em = $this->getContainer()->get("doctrine.orm.default_entity_manager");

        $post = new BlogPost();
        $post->setTitle($input->getArgument('title'));
        $post->setContent($input->getOption('content'));
        $post->setCreatedAt(new \DateTime());
        $em->persist($post);
        $em->flush();

        $output->writeln("<info>Post inserted!</info>");
    }
}
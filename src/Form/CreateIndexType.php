<?php

namespace App\Form;

use App\Manager\CallManager;
use App\Model\CallRequestModel;
use App\Model\ElasticsearchIndexModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Contracts\Translation\TranslatorInterface;

class CreateIndexType extends AbstractType
{
    public function __construct(CallManager $callManager, TranslatorInterface $translator)
    {
        $this->callManager = $callManager;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fields = [];

        if (false == $options['update']) {
            $fields[] = 'name';
            $fields[] = 'settings';
        }
        $fields[] = 'mappings';

        foreach ($fields as $field) {
            switch ($field) {
                case 'name':
                    $builder->add('name', TextType::class, [
                        'label' => 'name',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ],
                        'attr' => [
                            'data-break-after' => 'yes',
                        ],
                    ]);
                    break;
                case 'settings':
                    $builder->add('settings', TextareaType::class, [
                        'label' => 'settings',
                        'required' => false,
                        'constraints' => [
                            new Json(),
                        ],
                        'attr' => [
                            'data-break-after' => 'yes',
                        ],
                    ]);
                    break;
                case 'mappings':
                    $builder->add('mappings', TextareaType::class, [
                        'label' => 'mappings',
                        'required' => false,
                        'constraints' => [
                            new Json(),
                        ],
                    ]);
                    break;
            }
        }

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($options) {
            $form = $event->getForm();

            if ($form->has('mappings') && $form->get('mappings')->getData()) {
                $fieldOptions = $form->get('mappings')->getConfig()->getOptions();
                $fieldOptions['data'] = json_encode($form->get('mappings')->getData(), JSON_PRETTY_PRINT);
                $form->add('mappings', TextareaType::class, $fieldOptions);
            }

            if ($form->has('settings') && $form->get('settings')->getData()) {
                $fieldOptions = $form->get('settings')->getConfig()->getOptions();
                $fieldOptions['data'] = json_encode($form->get('settings')->getData(), JSON_PRETTY_PRINT);
                $form->add('settings', TextareaType::class, $fieldOptions);
            }
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
            $form = $event->getForm();

            if (false == $options['update']) {
                if ($form->has('name') && $form->get('name')->getData()) {
                    $callRequest = new CallRequestModel();
                    $callRequest->setMethod('HEAD');
                    $callRequest->setPath('/'.$form->get('name')->getData());
                    $callResponse = $this->callManager->call($callRequest);

                    if (Response::HTTP_OK == $callResponse->getCode()) {
                        $form->get('name')->addError(new FormError(
                            $this->translator->trans('name_already_used')
                        ));
                    }
                }
            }

            if ($form->has('settings') && $form->get('settings')->getData()) {
                $template = $event->getData();
                $template->setSettings(json_decode($form->get('settings')->getData(), true));
                $event->setData($template);
            }

            if ($form->has('mappings') && $form->get('mappings')->getData()) {
                $template = $event->getData();
                $template->setMappings(json_decode($form->get('mappings')->getData(), true));
                $event->setData($template);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ElasticsearchIndexModel::class,
            'update' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'data';
    }
}

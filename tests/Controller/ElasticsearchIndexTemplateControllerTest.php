<?php

namespace App\Tests\Controller;

use App\Tests\Controller\AbstractAppControllerTest;

use App\Model\CallRequestModel;

#[Route('/admin')]
class ElasticsearchIndexTemplateControllerTest extends AbstractAppControllerTest
{
    #[Route('/index-templates', name: 'index_templates')]
    public function testIndex(): void
    {
        $this->client->request('GET', '/admin/index-templates');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(200);
            $this->assertPageTitleSame('Composable index templates');
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextContains('h3', 'List');
        }
    }

    #[Route('/index-templates/create', name: 'index_templates_create')]
    public function testCreate(): void
    {
        $this->client->request('GET', '/admin/index-templates/create');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(200);
            $this->assertPageTitleSame('Composable index templates - Create composable index template');
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h3', 'Create composable index template');

            $values = [
                'data[name]' => GENERATED_NAME,
                'data[index_patterns]' => GENERATED_NAME,
            ];
            $this->client->submitForm('Submit', $values);

            $this->assertResponseStatusCodeSame(302);

            $this->client->followRedirect();
            $this->assertPageTitleSame('Composable index templates - '.GENERATED_NAME);
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h2', GENERATED_NAME);
            $this->assertSelectorTextSame('h3', 'Summary');
        }
    }

    public function testCreateSystem(): void
    {
        $this->client->request('GET', '/admin/index-templates/create');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(200);
            $this->assertPageTitleSame('Composable index templates - Create composable index template');
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h3', 'Create composable index template');

            $values = [
                'data[name]' => GENERATED_NAME_SYSTEM,
                'data[index_patterns]' => GENERATED_NAME_SYSTEM,
            ];
            $this->client->submitForm('Submit', $values);

            $this->assertResponseStatusCodeSame(302);

            $this->client->followRedirect();
            $this->assertPageTitleSame('Composable index templates - '.GENERATED_NAME_SYSTEM);
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h2', GENERATED_NAME_SYSTEM);
            $this->assertSelectorTextSame('h3', 'Summary');
        }
    }

    public function testCreateCopy404(): void
    {
        $this->client->request('GET', '/admin/index-templates/create?template='.uniqid());

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(404);
        }
    }

    public function testCreateCopy403(): void
    {
        $this->client->request('GET', '/admin/index-templates/create?template='.GENERATED_NAME_SYSTEM);

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(403);
        }
    }

    public function testCreateCopy(): void
    {
        $this->client->request('GET', '/admin/index-templates/create?template='.GENERATED_NAME);

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(200);
            $this->assertPageTitleSame('Composable index templates - Create composable index template');
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h3', 'Create composable index template');

            $values = [
                'data[index_patterns]' => GENERATED_NAME.'-copy',
            ];
            $this->client->submitForm('Submit', $values);

            $this->assertResponseStatusCodeSame(302);

            $this->client->followRedirect();
            $this->assertPageTitleSame('Composable index templates - '.GENERATED_NAME.'-copy');
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h2', GENERATED_NAME.'-copy');
            $this->assertSelectorTextSame('h3', 'Summary');
        }
    }

    #[Route('/index-templates/{name}', name: 'index_templates_read')]
    public function testRead404(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.uniqid());

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(404);
        }
    }

    public function testRead(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.GENERATED_NAME);

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(200);
            $this->assertPageTitleSame('Composable index templates - '.GENERATED_NAME);
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h2', GENERATED_NAME);
            $this->assertSelectorTextSame('h3', 'Summary');
        }
    }

    #[Route('/index-templates/{name}/update', name: 'index_templates_update')]
    public function testUpdate404(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.uniqid().'/update');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(404);
        }
    }

    public function testUpdate403(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.GENERATED_NAME_SYSTEM.'/update');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(403);
        }
    }

    public function testUpdate(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.GENERATED_NAME.'/update');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(200);
            $this->assertPageTitleSame('Composable index templates - '.GENERATED_NAME.' - Update');
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h2', GENERATED_NAME);
            $this->assertSelectorTextSame('h3', 'Update');
        }
    }

    #[Route('/index-templates/{name}/settings', name: 'index_templates_read_settings')]
    public function testSettings404(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.uniqid().'/settings');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(404);
        }
    }

    public function testSettings(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.GENERATED_NAME.'/settings');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(200);
            $this->assertPageTitleSame('Composable index templates - '.GENERATED_NAME.' - Settings');
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h2', GENERATED_NAME);
            $this->assertSelectorTextSame('h3', 'Settings');
        }
    }

    #[Route('/index-templates/{name}/mappings', name: 'index_templates_read_mappings')]
    public function testMappings404(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.uniqid().'/mappings');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(404);
        }
    }

    public function testMappings(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.GENERATED_NAME.'/mappings');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(200);
            $this->assertPageTitleSame('Composable index templates - '.GENERATED_NAME.' - Mappings');
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h2', GENERATED_NAME);
            $this->assertSelectorTextSame('h3', 'Mappings');
        }
    }

    #[Route('/index-templates/{name}/simulate', name: 'index_templates_simulate')]
    public function testSimulate404(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.uniqid().'/simulate');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(404);
        }
    }

    public function testSimulate(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.GENERATED_NAME.'/simulate');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(200);
            $this->assertPageTitleSame('Composable index templates - '.GENERATED_NAME.' - Simulate');
            $this->assertSelectorTextSame('h1', 'Composable index templates');
            $this->assertSelectorTextSame('h2', GENERATED_NAME);
            $this->assertSelectorTextSame('h3', 'Simulate');
        }
    }

    #[Route('/index-templates/{name}/delete', name: 'index_templates_delete')]
    public function testDelete404(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.uniqid().'/delete');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(404);
        }
    }

    public function testDelete403(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.GENERATED_NAME_SYSTEM.'/delete');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(403);

            $callRequest = new CallRequestModel();
            $callRequest->setMethod('DELETE');
            $callRequest->setPath('/_index_template/'.GENERATED_NAME_SYSTEM);
            $this->callManager->call($callRequest);
        }
    }

    public function testDelete(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.GENERATED_NAME.'/delete');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(302);
        }
    }

    public function testDeleteCopy(): void
    {
        $this->client->request('GET', '/admin/index-templates/'.GENERATED_NAME.'-copy/delete');

        if (false == $this->callManager->hasFeature('composable_template')) {
            $this->assertResponseStatusCodeSame(403);
        } else {
            $this->assertResponseStatusCodeSame(302);
        }
    }
}

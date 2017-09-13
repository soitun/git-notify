<?php

namespace Yansongda\GitNotify\Gateways\Destinations;

use Closure;
use Pimple\Container;
use Yansongda\Supports\Log;
use Yansongda\Supports\Traits\HasHttpRequest;
use Yansongda\GitNotify\Contracts\SourceInterface;
use Yansongda\GitNotify\Contracts\DestinationInterface;
use Yansongda\GitNotify\Exceptions\GatewayException;

class DingtalkGateway implements DestinationInterface
{
    use HasHttpRequest;

    /**
     * gateway
     *
     * @var string
     */
    protected $gateway = 'local';

    /**
     * send data
     *
     * @var array
     */
    protected $data;

    /**
     * app.
     *
     * @var Container
     */
    protected $app;

    /**
     * bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param SourceInterface $from
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        
        $this->setTemplate();
    }

    /**
     * send.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    public function send()
    {
        if ($this->gateway === 'local') {
            Log::debug('send data:', $this->data);

            return 'success';
        }

        return $this->post(
            $this->gateway,
            json_encode($this->data),
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]
        );
    }

    /**
     * set template
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param Closure|null $template
     */
    public function setTemplate(Closure $template = null)
    {
        if ($template == null) {
            $this->data['msgtype'] = 'text';
            $this->data['text']['content'] = "项目名称：" . $this->app->from->getRepoName() .
                                            "\n\n项目描述：" . $this->app->from->getRepoDes() .
                                            "\n\n推送理由：" . $this->app->from->getReason() .
                                            "\n\n推送时间：" . date('Y-m-d H:i:s');
            $this->data['at'] = ["isAtAll" => true];
        } else {
            $this->data = $template($this->app->from);
        }
        
    }

    /**
     * magic set.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $id
     * @param mixed $value
     */
    public function __set($id, $value)
    {
        $this->gateway = $value;
    }
}

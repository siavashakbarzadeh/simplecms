<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/secretmanager/v1/service.proto

namespace Google\Cloud\SecretManager\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for [SecretManagerService.ListSecretVersions][google.cloud.secretmanager.v1.SecretManagerService.ListSecretVersions].
 *
 * Generated from protobuf message <code>google.cloud.secretmanager.v1.ListSecretVersionsRequest</code>
 */
class ListSecretVersionsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the [Secret][google.cloud.secretmanager.v1.Secret] associated with the
     * [SecretVersions][google.cloud.secretmanager.v1.SecretVersion] to list, in the format
     * `projects/&#42;&#47;secrets/&#42;`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $parent = '';
    /**
     * Optional. The maximum number of results to be returned in a single page. If
     * set to 0, the server decides the number of results to return. If the
     * number is greater than 25000, it is capped at 25000.
     *
     * Generated from protobuf field <code>int32 page_size = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $page_size = 0;
    /**
     * Optional. Pagination token, returned earlier via
     * ListSecretVersionsResponse.next_page_token][].
     *
     * Generated from protobuf field <code>string page_token = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $page_token = '';
    /**
     * Optional. Filter string, adhering to the rules in
     * [List-operation
     * filtering](https://cloud.google.com/secret-manager/docs/filtering). List
     * only secret versions matching the filter. If filter is empty, all secret
     * versions are listed.
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $filter = '';

    /**
     * @param string $parent Required. The resource name of the [Secret][google.cloud.secretmanager.v1.Secret] associated with the
     *                       [SecretVersions][google.cloud.secretmanager.v1.SecretVersion] to list, in the format
     *                       `projects/&#42;/secrets/*`. Please see
     *                       {@see SecretManagerServiceClient::secretName()} for help formatting this field.
     *
     * @return \Google\Cloud\SecretManager\V1\ListSecretVersionsRequest
     *
     * @experimental
     */
    public static function build(string $parent): self
    {
        return (new self())
            ->setParent($parent);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The resource name of the [Secret][google.cloud.secretmanager.v1.Secret] associated with the
     *           [SecretVersions][google.cloud.secretmanager.v1.SecretVersion] to list, in the format
     *           `projects/&#42;&#47;secrets/&#42;`.
     *     @type int $page_size
     *           Optional. The maximum number of results to be returned in a single page. If
     *           set to 0, the server decides the number of results to return. If the
     *           number is greater than 25000, it is capped at 25000.
     *     @type string $page_token
     *           Optional. Pagination token, returned earlier via
     *           ListSecretVersionsResponse.next_page_token][].
     *     @type string $filter
     *           Optional. Filter string, adhering to the rules in
     *           [List-operation
     *           filtering](https://cloud.google.com/secret-manager/docs/filtering). List
     *           only secret versions matching the filter. If filter is empty, all secret
     *           versions are listed.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Secretmanager\V1\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource name of the [Secret][google.cloud.secretmanager.v1.Secret] associated with the
     * [SecretVersions][google.cloud.secretmanager.v1.SecretVersion] to list, in the format
     * `projects/&#42;&#47;secrets/&#42;`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The resource name of the [Secret][google.cloud.secretmanager.v1.Secret] associated with the
     * [SecretVersions][google.cloud.secretmanager.v1.SecretVersion] to list, in the format
     * `projects/&#42;&#47;secrets/&#42;`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Optional. The maximum number of results to be returned in a single page. If
     * set to 0, the server decides the number of results to return. If the
     * number is greater than 25000, it is capped at 25000.
     *
     * Generated from protobuf field <code>int32 page_size = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     * Optional. The maximum number of results to be returned in a single page. If
     * set to 0, the server decides the number of results to return. If the
     * number is greater than 25000, it is capped at 25000.
     *
     * Generated from protobuf field <code>int32 page_size = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setPageSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_size = $var;

        return $this;
    }

    /**
     * Optional. Pagination token, returned earlier via
     * ListSecretVersionsResponse.next_page_token][].
     *
     * Generated from protobuf field <code>string page_token = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getPageToken()
    {
        return $this->page_token;
    }

    /**
     * Optional. Pagination token, returned earlier via
     * ListSecretVersionsResponse.next_page_token][].
     *
     * Generated from protobuf field <code>string page_token = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->page_token = $var;

        return $this;
    }

    /**
     * Optional. Filter string, adhering to the rules in
     * [List-operation
     * filtering](https://cloud.google.com/secret-manager/docs/filtering). List
     * only secret versions matching the filter. If filter is empty, all secret
     * versions are listed.
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Optional. Filter string, adhering to the rules in
     * [List-operation
     * filtering](https://cloud.google.com/secret-manager/docs/filtering). List
     * only secret versions matching the filter. If filter is empty, all secret
     * versions are listed.
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setFilter($var)
    {
        GPBUtil::checkString($var, True);
        $this->filter = $var;

        return $this;
    }

}


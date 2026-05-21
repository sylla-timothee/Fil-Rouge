
Enum "users_role_enum" {
  "admin"
  "agent"
  "client"
}

Enum "properties_type_enum" {
  "residential"
  "professional"
}

Enum "properties_status_enum" {
  "available"
  "sold"
  "pending"
}

Table "users" {
  "id" INT [pk, not null, increment]
  "first_name" VARCHAR(50) [not null]
  "last_name" VARCHAR(50) [not null]
  "password" VARCHAR(255) [not null]
  "email" VARCHAR(100) [unique, not null]
  "role" users_role_enum [not null, default: 'client']
  "created_at" TIMESTAMP [not null, default: `CURRENT_TIMESTAMP`]
}

Table "agencies" {
  "id" INT [pk, not null, increment]
  "city" VARCHAR(50) [not null]
  "address" VARCHAR(100) [not null]
  "phone" VARCHAR(20) [not null]
}

Table "properties" {
  "id" INT [pk, not null, increment]
  "agency_id" INT [not null]
  "agent_id" INT [not null]
  "title" VARCHAR(100) [not null]
  "city" VARCHAR(50) [not null]
  "surface" INT [not null]
  "address" VARCHAR(100) [not null]
  "prix" INT [not null]
  "type" properties_type_enum [not null]
  "status" properties_status_enum [not null, default: 'available']
}

Table "properties_images" {
  "id" INT [pk, not null, increment]
  "property_id" INT [not null]
  "url" VARCHAR(255) [not null]
  "sort_order" INT [not null, default: 1]
}

Table "transactions" {
  "id" INT [pk, not null, increment]
  "property_id" INT [not null]
  "seller_id" INT [not null]
  "buyer_id" INT [not null]
  "agency_id" INT [not null]
  "date" TIMESTAMP [not null, default: `CURRENT_TIMESTAMP`]
}

Ref "fk_properties_agency":"agencies"."id" < "properties"."agency_id"

Ref "fk_properties_agent":"users"."id" < "properties"."agent_id"

Ref "fk_images_property":"properties"."id" < "properties_images"."property_id" [delete: cascade]

Ref "fk_trans_property":"properties"."id" < "transactions"."property_id"

Ref "fk_trans_seller":"users"."id" < "transactions"."seller_id"

Ref "fk_trans_buyer":"users"."id" < "transactions"."buyer_id"

Ref "fk_trans_agency":"agencies"."id" < "transactions"."agency_id"

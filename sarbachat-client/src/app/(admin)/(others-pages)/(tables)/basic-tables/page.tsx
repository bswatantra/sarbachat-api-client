'use client'
import ComponentCard from "@/components/common/ComponentCard";
import PageBreadcrumb from "@/components/common/PageBreadCrumb";
import BasicTableOne from "@/components/tables/BasicTableOne";
import useSocialAuth from "@/hooks/useSocialAuth";
import React from "react";


export default function BasicTables() {
   const { connectSocialPage } = useSocialAuth();

  const handleSocialLink =()=>{
    connectSocialPage('facebook')
  }
  return (
    <div>
      <PageBreadcrumb pageTitle="Social Users" />
      <div className="space-y-6">
        <ComponentCard title="Users" button={{
          visible: true,
          title: "Link Facebook",
          variant: "primary",
        }}
        handleSubmit={handleSocialLink}
        >
          <BasicTableOne />
        </ComponentCard>
      </div>
    </div>
  );
}

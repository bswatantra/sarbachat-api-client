'use client'
import ComponentCard from "@/components/common/ComponentCard";
import PageBreadcrumb from "@/components/common/PageBreadCrumb";
import LinkDropdown from "@/components/soicail/LinkDropdown";
import BasicTableOne from "@/components/tables/BasicTableOne";

import useSocialAuth from "@/hooks/useSocialAuth";
import React from "react";


export default function BasicTables() {
  const { connectSocialPage } = useSocialAuth();

  const handleSocialLink = () => {
    connectSocialPage('facebook')
  }
  return (
    <div>
      <PageBreadcrumb pageTitle="Social Users" />
      <div className="space-y-6">
        <ComponentCard title="Users"
          headerComponent={<LinkDropdown handleSocialLink={handleSocialLink} />}
        >
          <BasicTableOne />
        </ComponentCard>
      </div>
    </div>
  );
}

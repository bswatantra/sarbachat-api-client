import { TProvider } from "@/types";
import { useCallback } from "react";


const useSocialAuth = () => {
  const baseURL = process.env.NEXT_PUBLIC_API_BASE_URL;

  const connectSocialPage = useCallback((provider: TProvider) => {
    if (!provider) return;

    const url = new URL(`${baseURL}/api/social/${provider}`);
    window.open(url.toString(), "_blank");
  }, []);

  return { connectSocialPage };
};

export default useSocialAuth;
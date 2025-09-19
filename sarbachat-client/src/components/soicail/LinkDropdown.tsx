import { BoxIcon } from "@/icons"
import Button from "../ui/button/Button"
import { Dropdown } from "../ui/dropdown/Dropdown"
import { DropdownItem } from "../ui/dropdown/DropdownItem"
import { useState } from "react"

interface ComponentLinkDropdownProps {
  handleSocialLink?: (media: string) => void;
}

const LinkDropdown: React.FC<ComponentLinkDropdownProps> = ({ handleSocialLink }) => {
  const [isOpen, setIsOpen] = useState(false);

  function toggleDropdown() {
    setIsOpen(!isOpen);
  }

  function handleSocialClick(media: string) {
    setIsOpen(false);
    if (handleSocialLink) {
      handleSocialLink(media);
    }
  }

  return (
    <div className="relative inline-block mt-4">
      <Button
        className="dropdown-toggle"
        size="sm"
        variant="primary"
        startIcon={<BoxIcon />}
        onClick={toggleDropdown}
      >
        Link Account
      </Button>
      <Dropdown
        isOpen={isOpen}
        onClose={() => setIsOpen(false)}
        className="w-40 p-2"
      >
        <DropdownItem
          onItemClick={() => handleSocialClick('facebook')}
          className="flex w-full font-normal text-left text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
        >
          Facebook
        </DropdownItem>
        <DropdownItem
          onItemClick={() => handleSocialClick('instagram')}
          className="flex w-full font-normal text-left text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
        >
          Instagram
        </DropdownItem>
      </Dropdown>
    </div>
  );
};

export default LinkDropdown;

import React from 'react';
import { NavLink, useParams } from 'react-router-dom';
import { VisionNavigationLinks } from '../../../../enums';

import { assistant_info_navigation } from '../../config';

const navigation_values = ['16/21', '9/14', '3/8'];

const AssistantInfoNavigation = () => {
  const { assistantId } = useParams<{ assistantId: string }>();

  return (
    <div className="assistant-info-navigation vision-navigation">
      {assistant_info_navigation.map(({ title, link }, index) => (
        <NavLink
          key={link}
          to={`${VisionNavigationLinks.assistants}/${assistantId}/${link}`}
          activeClassName="vision-navigation__link-active"
          className="vision-navigation__link"
        >
          {title + (navigation_values[index] || '')}
        </NavLink>
      ))}
    </div>
  );
};

export default AssistantInfoNavigation;

import React from 'react';
import { NavLink } from 'react-router-dom';
import { DashboardAssistantInfoNavigationLinks } from '../../../../enums';

import { assistant_info_navigation } from '../../config';

const navigation_values = ['16/21', '9/14', '3/8'];

const DashboardAssistantInfoNavigation = () => (
  <div className="assistant-info-navigation vision-navigation">
    <NavLink
      key={assistant_info_navigation[0].link}
      to={assistant_info_navigation[0].link}
      activeClassName="navigation__link-active"
      className="navigation__link"
      isActive={(_, { pathname }) => ['/', DashboardAssistantInfoNavigationLinks.set].includes(pathname)}
    >
      {assistant_info_navigation[0].title + (navigation_values[0] || '')}
    </NavLink>

    {assistant_info_navigation.map(({ title, link }, index) => {
      if (!index) return null;

      return (
        <NavLink
          key={link}
          to={link}
          activeClassName="navigation__link-active"
          className="navigation__link"
        >
          {title + (navigation_values[index] || '')}
        </NavLink>
      );
    })}
  </div>
);

export default DashboardAssistantInfoNavigation;

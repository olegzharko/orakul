import React from 'react';
import { NavLink } from 'react-router-dom';

import '../../index.scss';
import { navigation } from '../../config';
import { VisionNavigationLinks } from '../../enums';

const VisionNavigation = () => (
  <div className="vision-navigation">
    <NavLink
      key={navigation[0].link}
      to={navigation[0].link}
      activeClassName="vision-navigation__link-active"
      className="vision-navigation__link"
      isActive={(_, { pathname }) => ['/', VisionNavigationLinks.clientSide].includes(pathname)}
    >
      {navigation[0].title}
    </NavLink>

    {navigation.map(({ title, link }, index) => {
      if (!index) return null;

      return (
        <NavLink
          key={link}
          to={link}
          activeClassName="vision-navigation__link-active"
          className="vision-navigation__link"
        >
          {title}
        </NavLink>
      );
    })}
  </div>
);

export default VisionNavigation;

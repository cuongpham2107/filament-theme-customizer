@php
    $navigation = filament()->getNavigation();
@endphp

<div class="fi-custom-topbar-nav" x-data="{}" x-cloak>
    <ul class="fi-topbar-nav-groups">
        @foreach ($navigation as $group)
            @php
                $groupLabel = $group->getLabel();
                $groupExtraTopbarAttributeBag = $group->getExtraTopbarAttributeBag();
                $isGroupActive = $group->isActive();
                $groupIcon = $group->getIcon();
            @endphp

            @if ($groupLabel)
                <x-filament::dropdown
                    placement="bottom-start"
                    teleport
                    :attributes="\Filament\Support\prepare_inherited_attributes($groupExtraTopbarAttributeBag)"
                >
                    <x-slot name="trigger">
                        <x-filament-panels::topbar.item
                            :active="$isGroupActive"
                            :icon="$groupIcon"
                        >
                            {{ $groupLabel }}
                        </x-filament-panels::topbar.item>
                    </x-slot>

                    <x-filament::dropdown.list>
                        @foreach ($group->getItems() as $item)
                            @php
                                $isItemActive = $item->isActive();
                                $itemBadge = $item->getBadge();
                                $itemBadgeColor = $item->getBadgeColor($itemBadge);
                                $itemBadgeTooltip = $item->getBadgeTooltip($itemBadge);
                                $itemUrl = $item->getUrl();
                                $itemIcon = $isItemActive ? ($item->getActiveIcon() ?? $item->getIcon()) : $item->getIcon();
                                $shouldItemOpenUrlInNewTab = $item->shouldOpenUrlInNewTab();
                                $itemExtraAttributes = $item->getExtraAttributeBag();
                            @endphp

                            <x-filament::dropdown.list.item
                                :badge="$itemBadge"
                                :badge-color="$itemBadgeColor"
                                :badge-tooltip="$itemBadgeTooltip"
                                :color="$isItemActive ? 'primary' : 'gray'"
                                :href="$itemUrl"
                                :icon="$itemIcon"
                                tag="a"
                                :target="$shouldItemOpenUrlInNewTab ? '_blank' : null"
                                :aria-current="$isItemActive ? 'page' : null"
                                :attributes="\Filament\Support\prepare_inherited_attributes($itemExtraAttributes)"
                            >
                                {{ $item->getLabel() }}
                            </x-filament::dropdown.list.item>
                        @endforeach
                    </x-filament::dropdown.list>
                </x-filament::dropdown>
            @else
                @foreach ($group->getItems() as $item)
                    @php
                        $isItemActive = $item->isActive();
                        $itemActiveIcon = $item->getActiveIcon();
                        $itemBadge = $item->getBadge();
                        $itemBadgeColor = $item->getBadgeColor($itemBadge);
                        $itemBadgeTooltip = $item->getBadgeTooltip($itemBadge);
                        $itemIcon = $item->getIcon();
                        $shouldItemOpenUrlInNewTab = $item->shouldOpenUrlInNewTab();
                        $itemUrl = $item->getUrl();
                        $itemExtraAttributes = $item->getExtraAttributeBag();
                    @endphp

                    <x-filament-panels::topbar.item
                        :active="$isItemActive"
                        :active-icon="$itemActiveIcon"
                        :badge="$itemBadge"
                        :badge-color="$itemBadgeColor"
                        :badge-tooltip="$itemBadgeTooltip"
                        :icon="$itemIcon"
                        :should-open-url-in-new-tab="$shouldItemOpenUrlInNewTab"
                        :url="$itemUrl"
                        :attributes="\Filament\Support\prepare_inherited_attributes($itemExtraAttributes)"
                    >
                        {{ $item->getLabel() }}
                    </x-filament-panels::topbar.item>
                @endforeach
            @endif
        @endforeach
    </ul>
</div>
